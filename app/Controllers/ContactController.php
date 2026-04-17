<?php

declare(strict_types=1);

final class ContactController extends BaseController
{
    /** Same-origin referer (e.g. home #contact) or /contact — avoids losing flash after POST. */
    private function redirectBackToForm(): never
    {
        $ref = $this->request->header('Referer') ?? '';
        $base = rtrim((string) APP_URL, '/');
        if (\is_string($ref) && $ref !== '' && str_starts_with($ref, $base)) {
            $this->response->redirect($ref);
        }
        $this->response->redirect(base_url('contact'));
    }

    public function index(): void
    {
        $settings = $this->siteSettings();
        $this->render('contact/index', [
            'pageTitle' => 'Contact Us - Wincon Pilling Construction Limited',
            'metaDescription' => 'Contact Wincon Pilling Construction Limited for quotes, piling, and land inquiries.',
            'settings' => $settings,
        ]);
    }

    public function send(): void
    {
        /* Avoid names like "website" — browsers/password managers autofill them and block real users. */
        $hp = trim((string) ($this->request->postRaw('_hp') ?? ''));
        $hpExtra = trim((string) ($this->request->postRaw('_hp_extra') ?? ''));
        if ($hp !== '' || $hpExtra !== '') {
            Session::flash('contact_error', 'Submission could not be verified. If you use autofill, try again or clear the form and re-enter your details.');
            $this->redirectBackToForm();
        }

        $ip = $this->request->ip();
        $limiter = new ContactIpLimiter();
        if ($limiter->tooManyAttempts($ip, 3, 3600)) {
            Session::flash('contact_error', 'Too many submissions from this address. Please try again later.');
            $this->redirectBackToForm();
        }

        $strip = static fn (string $s): string => strip_tags($s);
        $data = [
            'full_name' => $strip((string) $this->request->post('full_name', '')),
            'email' => (string) $this->request->post('email', ''),
            'subject' => $strip((string) $this->request->post('subject', '')),
            'message' => $strip((string) $this->request->post('message', '')),
            'service_interest' => $strip((string) $this->request->post('service_interest', '')),
        ];

        $validator = new Validator();
        $ok = $validator->validate($data, [
            'full_name' => 'required|max:100',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:10|max:2000',
        ]);

        if (!$ok) {
            Session::set('_old_input', [
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'service_interest' => $data['service_interest'],
                'message' => $data['message'],
            ]);
            Session::flash('errors', $validator->getErrors());
            $this->redirectBackToForm();
        }

        $messageModel = new MessageModel();
        $messageModel->create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'service_interest' => $data['service_interest'] !== '' ? $data['service_interest'] : null,
            'message' => $data['message'],
            'ip_address' => $ip,
        ]);

        $settings = $this->siteSettings();
        Mail::notifyContactSubmission($data, $settings['company_email'] ?? null);

        $limiter->recordSuccess($ip, 3600);
        Session::delete('_old_input');
        flash('success', 'Thank you! Your message has been sent.');
        $this->redirectBackToForm();
    }
}
