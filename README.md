# 📋 Kalite Standartları Portalı

**Elektrik Panosu Montajı için Profesyonel Kalite Kontrol Sistemi**

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.0+-38B2AC?logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-005C87?logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green)

## 🎯 Özellikler

✅ **Dinamik Kontrol Listesi** - Kalite standartlarına uygun checkbox sistemi
✅ **Marka Bazlı Etiket Oluşturucu** - PDF ve Baskı desteği
✅ **Fotoğraf Yükleme Modülü** - Drag & Drop, Batch işlemleri
✅ **Rapor Sistemi** - Dokümantasyon ve Arşivleme
✅ **İndustrial UI/UX** - Tailwind CSS ile profesyonel tasarım
✅ **Mobil Uyumlu** - 100% Responsive Design
✅ **REST API** - Tüm işlemler API üzerinden
✅ **Authentication** - Güvenli kullanıcı yönetimi
✅ **Dashboard** - Gerçek zamanlı istatistikler

## 📦 Sistem Gereksinimleri

- PHP 7.4 veya üzeri
- MySQL 8.0 veya MariaDB 10.5+
- Composer
- Node.js (CSS derleme için)
- Tarayıcı desteği: Chrome, Firefox, Safari, Edge (Son 2 sürüm)

## 🚀 Kurulum

### 1. Repository'yi Clone Edin

```bash
git clone https://github.com/ajansweb/kalite-portal.git
cd kalite-portal
```

### 2. Bağımlılıkları Yükleyin

```bash
composer install
npm install
```

### 3. Veritabanı Oluşturun

```bash
mysql -u root -p < database.sql
```

### 4. Konfigürasyon Dosyası

```bash
cp .env.example .env
# .env dosyasını düzenleyin
```

### 5. Web Sunucusu Başlatın

```bash
# PHP Built-in Server
php -S localhost:8000 -t public

# Veya Nginx/Apache kullanın (public klasörüne işaret edin)
```

### 6. Tarayıcıda Açın

```
http://localhost:8000
```

## 📂 Proje Yapısı

```
kalite-portal/
├── public/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── css/
│   │   ├── tailwind.css
│   │   └── custom.css
│   └── js/
│       ├── checklist.js
│       ├── label-generator.js
│       ├── photo-uploader.js
│       └── app.js
├── src/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── ChecklistController.php
│   │   ├── LabelController.php
│   │   ├── ReportController.php
│   │   └── DashboardController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Checklist.php
│   │   ├── Label.php
│   │   └── Report.php
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── main.php
│   │   │   ├── navbar.php
│   │   │   └── footer.php
│   │   ├── dashboard.php
│   │   ├── checklist.php
│   │   ├── label-generator.php
│   │   ├── report.php
│   │   └── uploads.php
│   └── services/
│       ├── ImageService.php
│       ├── PdfService.php
│       └── ValidationService.php
├── api/
│   ├── save-checklist.php
│   ├── save-label.php
│   ├── upload-photo.php
│   ├── save-report.php
│   └── get-statistics.php
├── config/
│   ├── database.php
│   ├── constants.php
│   └── app.php
├── uploads/
│   ├── photos/
│   ├── reports/
│   └── labels/
├── tests/
│   ├── ChecklistTest.php
│   ├── LabelTest.php
│   └── ReportTest.php
├── docker-compose.yml
├── Dockerfile
├── database.sql
├── .env.example
├── tailwind.config.js
├── package.json
├── composer.json
└── README.md
```

## 🔧 Konfigürasyon

### .env Dosyası

```bash
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=kalite_portal

APP_ENV=production
APP_URL=http://localhost:8000
APP_SECRET=your-secret-key-here

# Upload ayarları
MAX_UPLOAD_SIZE=50000000
ALLOWED_EXTENSIONS=jpg,jpeg,png,pdf
```

## 🎨 Kullanılan Teknolojiler

- **Frontend**: HTML5, Tailwind CSS, JavaScript (Vanilla)
- **Backend**: PHP (OOP)
- **Database**: MySQL/MariaDB
- **PDF**: TCPDF
- **Image Processing**: GD Library
- **API**: RESTful

## 📚 API Endpoints

### Checklist
```
POST   /api/save-checklist.php       - Kontrol listesi kaydet
GET    /api/get-checklists.php       - Kontrol listeleri listele
POST   /api/update-checklist.php     - Kontrol listesi güncelle
DELETE /api/delete-checklist.php     - Kontrol listesi sil
```

### Labels
```
POST   /api/save-label.php          - Etiket oluştur
GET    /api/get-labels.php          - Etiketleri listele
POST   /api/batch-labels.php        - Toplu etiket oluştur
GET    /api/download-label.php      - Etiket indir (PDF)
```

### Reports
```
POST   /api/save-report.php         - Rapor kaydet
GET    /api/get-reports.php         - Raporları listele
POST   /api/upload-photo.php        - Fotoğraf yükle
GET    /api/download-report.php     - Rapor indir (PDF)
```

## 🐳 Docker ile Çalıştırma

```bash
docker-compose up -d
docker-compose exec web php -r "require 'config/database.php';"
```

## 🧪 Testler

```bash
./vendor/bin/phpunit tests/
```

## 📝 Kullanıcı Rehberi

### Kontrol Listesi Oluşturma
1. Proje bilgilerini girin
2. İlgili kontrolleri seçin
3. Notları ekleyin
4. Kaydet butonuna tıklayın

### Etiket Tasarımı
1. Marka seçin
2. Devre numarasını girin
3. Renk seçin
4. Ön izlemede görüntüleyin
5. PDF indir veya yazdır

### Rapor Oluşturma
1. Fotoğrafları yükleyin (Drag & Drop)
2. Proje bilgilerini doldurun
3. Açıklama yazın
4. Rapor kaydedin
5. PDF olarak dışa aktarın

## 🔐 Güvenlik

- ✅ SQL Injection koruması (Prepared Statements)
- ✅ CSRF koruması
- ✅ XSS koruması (htmlspecialchars)
- ✅ Dosya yükleme validasyonu
- ✅ Şifre şifreleme (bcrypt)
- ✅ Session yönetimi
- ✅ Rate limiting

## 📊 Veritabanı Şeması

Veritabanı otomatik olarak `database.sql` ile oluşturulur. İçeriği:

- **users** - Kullanıcı hesapları
- **checklists** - Kontrol listeleri
- **labels** - Oluşturulan etiketler
- **reports** - İş raporları
- **photos** - Rapor fotoğrafları

## 🤝 Katkıda Bulunma

Katkılarınız memnuniyetle karşılanır!

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişiklikleri commit edin (`git commit -m 'Add amazing feature'`)
4. Branch'e push edin (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📄 Lisans

MIT License - Detaylar için [LICENSE](LICENSE) dosyasına bakın

## 💬 Destek

Sorunlarınız veya önerileriniz için [Issues](https://github.com/ajansweb/kalite-portal/issues) bölümünü kullanın.

## 👨‍💻 Geliştirici

**Ajansweb** - [GitHub Profili](https://github.com/ajansweb)

---

**Yapıldığı Tarih:** 2026-05-15  
**Son Güncelleme:** 2026-05-15  
**Sürüm:** 1.0.0
