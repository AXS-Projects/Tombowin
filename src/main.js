import './styles.css';

function showMessage(text) {
  const box = document.getElementById('ajax-message');
  if (box) {
    box.textContent = text;
    box.style.display = 'block';
    setTimeout(() => {
      box.style.display = 'none';
    }, 4000);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const serverMessage = document.querySelector('.message');
  if (serverMessage && serverMessage.id !== 'ajax-message') {
    setTimeout(() => {
      serverMessage.remove();
    }, 4000);
  }

  const countdown = document.getElementById('countdown');
  if (countdown) {
    const end = new Date(countdown.dataset.end).getTime();
    const update = () => {
      const diff = end - Date.now();
      if (diff <= 0) {
        countdown.textContent = 'Tombola a început!';
        clearInterval(timer);
        return;
      }
      const d = Math.floor(diff / (1000 * 60 * 60 * 24));
      const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const s = Math.floor((diff % (1000 * 60)) / 1000);
      countdown.textContent = `${d}z ${h}h ${m}m ${s}s`;
    };
    update();
    const timer = setInterval(update, 1000);
  }

  const form = document.getElementById('ticket-form');
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const data = new FormData(form);
      const response = await fetch(form.action, {
        method: 'POST',
        body: data,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (response.ok) {
        const json = await response.json();
        showMessage(json.message);
        form.reset();
      }
    });
  }
});
