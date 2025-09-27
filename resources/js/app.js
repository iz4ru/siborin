import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'

Alpine.plugin(focus)

// Cek apakah Alpine sudah ada
if (!window.Alpine) {
    window.Alpine = Alpine
    Alpine.start()
}
