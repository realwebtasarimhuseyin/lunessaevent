import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { readdirSync, statSync } from 'fs';
import { join } from 'path';

// Bir dizindeki dosyaları özyinelemeli (recursive) olarak toplamak için yardımcı fonksiyon
function dizindekiDosyalariAl(dir, dosyaUzantilari) {
    const dosyalar = [];
    const ogeler = readdirSync(dir); // Dizindeki tüm öğeleri al

    ogeler.forEach((oge) => {
        const tamYol = join(dir, oge); // Tam dosya yolunu oluştur
        if (statSync(tamYol).isDirectory()) {
            // Eğer bu bir dizinse, içindeki dosyaları özyinelemeli olarak topla
            dosyalar.push(...dizindekiDosyalariAl(tamYol, dosyaUzantilari));
        } else if (dosyaUzantilari.some(uzanti => oge.endsWith(uzanti))) {
            // Eğer dosya belirtilen uzantılardan birine sahipse, onu diziye ekle
            dosyalar.push(tamYol);
        }
    });

    return dosyalar; // Bulunan tüm dosyaları döndür
}

// Dahil etmek istediğiniz dosya yollarını ve dosya türlerini tanımlayın
const scssDosyalari = dizindekiDosyalariAl('resources/scss', ['.scss']); // SCSS dosyalarını topla
const cssDosyalari = dizindekiDosyalariAl('resources/css', ['.css']); // CSS dosyalarını topla
const layoutJsDosyalari = dizindekiDosyalariAl('resources/layouts', ['.js']); // Layout klasöründeki JS dosyalarını topla
const jsDosyalari = dizindekiDosyalariAl('resources/js', ['.js']); // JS dosyalarını topla
const resimDosyalari = dizindekiDosyalariAl('resources/images', ['.png', '.jpg', '.jpeg', '.gif', '.svg', '.ico']); // Resim dosyalarını topla

// Tüm dosyaları tek bir dizide birleştir
const inputDosyalari = [...scssDosyalari, ...cssDosyalari, ...layoutJsDosyalari, ...jsDosyalari, ...resimDosyalari];

// Vite yapılandırmasını dışa aktar
export default defineConfig({
    plugins: [
        laravel({
            input: inputDosyalari, // Vite'nin derleyeceği dosyaları belirle
            refresh: true, // Otomatik yenileme özelliğini etkinleştir
        }),
    ],
});
