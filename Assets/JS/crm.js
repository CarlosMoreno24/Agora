function showNotification(message, type = 'success', duration = 3000) {
    const notif = document.getElementById('crm-notification');
    notif.textContent = message;
    notif.className = `crm-notification show ${type}`;
    notif.style.top = '32px';
    setTimeout(() => {
        notif.classList.remove('show');
        notif.style.top = '16px';
    }, duration);
}