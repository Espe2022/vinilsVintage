<footer class="bg-marron-chocolate text-beige-tostado text-center py-6 mt-10">
    <div class="container mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Derechos -->
        <p class="text-sm order-2 sm:order-1">
            © {{ date('Y') }} Vinyls Vintage — Todos los derechos reservados.
        </p>

        <!-- Redes sociales -->
        <div class="flex justify-center sm:justify-end space-x-4 order-1 sm:order-2">
            <a href="https://facebook.com/vinylsvintage" target="_blank" aria-label="Síguenos en Facebook" rel="noopener noreferrer" 
               class="hover:text-oro-antiguo transition duration-300">
                <img src="{{ asset('icons/Facebook_Logo_Primary.png') }}" alt="Logo de Facebook de Vinyls Vintage" class="h-6 w-6" loading="lazy"/>
            </a>
            <a href="https://instagram.com/vinylsvintage" target="_blank" aria-label="Síguenos en Instagram" rel="noopener noreferrer" 
               class="hover:text-oro-antiguo transition duration-300">
                <img src="{{ asset('icons/Instagram_icon.png') }}" alt="Logo de Instagram de Vinyls Vintage" class="h-6 w-6" loading="lazy"/>
            </a>
            <a href="https://twitter.com/vinylsvintage" target="_blank" aria-label="Síguenos en Twitter" rel="noopener noreferrer" 
               class="hover:text-oro-antiguo transition duration-300">
                <img src="{{ asset('icons/logotipo-de-twitter.png') }}" alt="Logo de Twitter de Vinyls Vintage" class="h-6 w-6" loading="lazy"/>
            </a>
            <a href="https://tiktok.com/@vinylsvintage" target="_blank" aria-label="Síguenos en TikTok" rel="noopener noreferrer" 
               class="hover:text-oro-antiguo transition duration-300">
                <img src="{{ asset('icons/tik-tok.png') }}" alt="Logo de TikTok de Vinyls Vintage" class="h-6 w-6" loading="lazy"/>
            </a>
        </div>
    </div>
</footer>
