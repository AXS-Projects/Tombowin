import './styles.css';

document.addEventListener('DOMContentLoaded', () => {
  const message = document.querySelector('.message');
  if (message) {
    setTimeout(() => {
      message.remove();
    }, 4000);
  }
});
