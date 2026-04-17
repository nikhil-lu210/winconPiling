<?php
declare(strict_types=1);
$success = flash('success');
$error = flash('error');
$contactErr = Session::getFlash('contact_error');
$errors = Session::getFlash('errors');
if (!is_array($errors)) {
    $errors = [];
}
$errList = [];
foreach ($errors as $msg) {
    $errList[] = is_string($msg) ? $msg : (string) $msg;
}
$flashPayload = [
    'success' => is_string($success) && $success !== '' ? $success : null,
    'error' => is_string($error) && $error !== '' ? $error : null,
    'warning' => is_string($contactErr) && $contactErr !== '' ? $contactErr : null,
    'errors' => $errList !== [] ? $errList : null,
];
?>
<div id="wincon-toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090" aria-live="polite" aria-atomic="true"></div>
<script>
(function () {
    var data = <?= json_encode($flashPayload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) ?>;
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof bootstrap === 'undefined' || !bootstrap.Toast) return;
        var c = document.getElementById('wincon-toast-container');
        if (!c) return;
        function addToast(body, variant) {
            var wrap = document.createElement('div');
            wrap.className = 'toast align-items-center text-bg-' + variant + ' border-0 mb-2';
            wrap.setAttribute('role', 'alert');
            wrap.setAttribute('aria-live', 'assertive');
            wrap.setAttribute('aria-atomic', 'true');
            var flex = document.createElement('div');
            flex.className = 'd-flex';
            var inner = document.createElement('div');
            inner.className = 'toast-body';
            inner.style.whiteSpace = 'pre-wrap';
            inner.appendChild(document.createTextNode(body));
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = variant === 'warning' ? 'btn-close me-2 m-auto' : 'btn-close btn-close-white me-2 m-auto';
            btn.setAttribute('data-bs-dismiss', 'toast');
            btn.setAttribute('aria-label', 'Close');
            flex.appendChild(inner);
            flex.appendChild(btn);
            wrap.appendChild(flex);
            c.appendChild(wrap);
            var delay = variant === 'danger' ? 10000 : 7000;
            var t = new bootstrap.Toast(wrap, { delay: delay });
            t.show();
            wrap.addEventListener('hidden.bs.toast', function () { wrap.remove(); });
        }
        if (data.success) addToast(data.success, 'success');
        if (data.error) addToast(data.error, 'danger');
        if (data.warning) addToast(data.warning, 'warning');
        if (data.errors && data.errors.length) {
            addToast(data.errors.join('\n'), 'danger');
        }
    });
})();
</script>
