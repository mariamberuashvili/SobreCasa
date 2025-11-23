document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

const initApp = () => {
    initDarkMode();
    initEventListeners();
    checkWebpSupport();
};



const initDarkMode = () => {
    const botonDarkMode = document.querySelector('.dark-mode-boton');
    if (!botonDarkMode) return;

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
    const horaActual = new Date().getHours();
    const modoGuardado = localStorage.getItem('modo');

    const aplicarModo = (modo) => {
        document.body.classList.toggle('dark-mode', modo === 'oscuro');
        localStorage.setItem('modo', modo);
    };

    
    if (modoGuardado) {
        aplicarModo(modoGuardado);
    } else if (horaActual >= 19 || horaActual < 7) {
        aplicarModo('oscuro');
    } else {
        aplicarModo(prefersDark.matches ? 'oscuro' : 'claro');
    }

    
    prefersDark.addEventListener('change', (e) => {
        if (!localStorage.getItem('modo')) {
            aplicarModo(e.matches ? 'oscuro' : 'claro');
        }
    });

    
    botonDarkMode.addEventListener('click', () => {
        const nuevoModo = document.body.classList.contains('dark-mode') ? 'claro' : 'oscuro';
        aplicarModo(nuevoModo);
    });

    
    setInterval(() => {
        if (!localStorage.getItem('modo')) {
            const hora = new Date().getHours();
            aplicarModo(hora >= 19 || hora < 7 ? 'oscuro' : 'claro');
        }
    }, 60 * 60 * 1000);
};


const initEventListeners = () => {
   
    const mobileMenu = document.querySelector('.mobile-menu');
    const navegacion = document.querySelector('.navegacion');

    if (mobileMenu && navegacion) {
        mobileMenu.addEventListener('click', () => {
            navegacion.classList.toggle('mostrar');
        });
    }

    
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input =>
        input.addEventListener('click', seleccionarMetodo)
    );
};

const seleccionarMetodo = (e) => {
    const contactoDiv = document.querySelector('#contacto');
    if (!contactoDiv) return;

    
    contactoDiv.innerHTML = ''; 

   
    let htmlContenido = '';

    if (e.target.value === 'telefono') {
        htmlContenido = `
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="contacto[telefono]" placeholder="Tu teléfono" required>

            <label for="fecha">Fecha de llamada</label>
            <input type="date" id="fecha" name="contacto[fecha]" required>

            <label for="hora">Hora de llamada</label>
            <input type="time" id="hora" name="contacto[hora]" min="09:00" max="18:00" required>
        `;
    } else if (e.target.value === 'email') {
        htmlContenido = `
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="contacto[email]" placeholder="Tu email" required>
        `;
    }
    
    
    contactoDiv.innerHTML = htmlContenido;
};