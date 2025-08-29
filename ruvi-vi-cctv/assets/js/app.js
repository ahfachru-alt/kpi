document.addEventListener('DOMContentLoaded', () => {
  const sseEl = document.getElementById('sse-messages');
  if (sseEl) {
    const es = new EventSource(sseEl.dataset.url);
    es.onmessage = (e) => {
      try { const data = JSON.parse(e.data); console.log('SSE', data); } catch (_e) {}
    };
  }
});

