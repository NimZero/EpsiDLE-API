import 'flowbite';
import '../bootstrap';
import '../styles/app.css';

if (!('color-theme' in localStorage) || localStorage.getItem('color-theme') === 'system') {
  console.log('no data or system');
  document.documentElement.setAttribute('color-theme', 'system');
  if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    console.log('dark');
    document.documentElement.classList.add('dark');
  }
  else {
    console.log('light');
    document.documentElement.classList.remove('dark');
  }
}
else if (localStorage.getItem('color-theme') === 'dark') {
  console.log('dark');
  document.documentElement.classList.add('dark');
  document.documentElement.setAttribute('color-theme', 'dark');
}
else {
  console.log('light');
  document.documentElement.classList.remove('dark');
  document.documentElement.setAttribute('color-theme', 'light');
}
