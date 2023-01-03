if(document.querySelector('#mapa')) {
    const latitud =19.497881804187056;
    const longitud =-99.17511654547323;
    const zoom = 16;
    const map = L.map('mapa').setView([latitud,longitud], zoom);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitud,longitud]).addTo(map)
    .bindPopup(`
        <h2 class="mapa__heading">DevWebcamp</h2>
        <p class="mapa__texto">Arena Ciudad de Mexico</p>
     `)
    .openPopup();
}