<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::query()->delete();

        $faqs = [
            [
                'question' => 'Bagaimana jika lupa password akun saya?',
                'answer' => "Jika Anda lupa password, silakan hubungi Admin Sekolah melalui:\n1. Menu Bantuan > Laporkan Masalah, pilih kategori Masalah Akses/Akun.\n2. Email resmi sekolah: admin@sman1tuhemberua.sch.id.\n3. WhatsApp/Telepon operator sekolah pada jam kerja.\n\nAdmin akan mereset password Anda melalui menu Reset Password. Setelah direset, silakan login menggunakan password default dari Admin lalu segera ganti melalui menu Profil > Ubah Password demi keamanan akun Anda. PASSWORD TIDAK PERNAH DAPAT DILIHAT OLEH SIAPAPUN (termasuk Admin) karena sistem menggunakan HASHING yang satu arah.",
                'for_role' => 'all',
                'sort_order' => 1,
            ],
            [
                'question' => 'Mengapa setelah registrasi saya belum dapat login?',
                'answer' => "Sistem SIAKAD SMAN 1 Tuhemberua menggunakan VERIFIKASI ADMIN untuk keamanan. Setelah Anda submit form Registrasi:\n\n1. Akun Anda otomatis berstatus **PENDING** (menunggu verifikasi).\n2. Semua Admin sekolah menerima NOTIFIKASI di ikon lonceng Dashboard bahwa ada akun baru yang mendaftar.\n3. Admin memeriksa data Anda (nama, data pendukung, kelas untuk Siswa / mapel untuk Guru).\n4. JIKA DISETUJUI → status berubah ACTIVE. Anda juga menerima notifikasi \"Akun Disetujui\" saat login pertama, dan Anda BISA login.\n5. JIKA DITOLAK → Anda menerima notifikasi penolakan beserta alasan. Silakan perbaiki data lalu registrasi ulang atau konfirmasi ke Admin.\n\nCatatan: Status PENDING / REJECTED / INACTIVE TIDAK BISA login walau username & password benar (diblokir oleh sistem middleware CheckUserStatus).",
                'for_role' => 'all',
                'sort_order' => 2,
            ],
            [
                'question' => 'Bagaimana cara mengetahui akun sudah diverifikasi Admin?',
                'answer' => "Ada 3 cara:\n\n1. **Coba Login Langsung**\n   Jika Anda sudah **BISA login** dan masuk ke dashboard (tidak ada error \"Akun belum aktif\"), berarti akun Anda SUDAH disetujui Admin (status=ACTIVE).\n\n2. **Cek Ikon Lonceng Notifikasi**\n   Saat pertama login sukses, lihat ikon lonceng pojok kanan atas. Jika akun baru disetujui, akan ada notifikasi:\n   → Judul: **Akun Disetujui**\n   → Pesan: \"Selamat! Akun {Role} Anda telah disetujui oleh Admin. Silakan login untuk mengakses sistem.\"\n\n3. **Hubungi Admin**\n   Jika sudah lebih dari 1 hari kerja tidak ada kabar, konfirmasi ke Admin melalui menu Bantuan > Laporkan Masalah dengan kategori Masalah Akses.",
                'for_role' => 'all',
                'sort_order' => 3,
            ],
            [
                'question' => 'Mengapa saya tidak dapat membuka menu tertentu?',
                'answer' => "Sistem SIAKad menggunakan **RBAC (Role-Based Access Control)** berlapis 2:\n\n**Lapisan 1: Sidebar menyembunyikan menu**\nHanya menu yang sesuai peran Anda yang ditampilkan.\n\n**Lapisan 2: Middleware Backend memblokir URL**\nJika Anda memaksa ketik URL sendiri (misal Siswa membuka /admin/dashboard), maka sistem akan otomatis:\n→ Logout paksa\n→ Redirect ke halaman login\n→ Menampilkan pesan error akses ditolak\n\nBeberapa contoh pembatasan:\n• Siswa → tidak boleh akses Verifikasi Pengguna, Input Nilai, Reset Password user lain\n• Guru → tidak boleh mengubah data master kelas/mapel, approve user\n• Admin → boleh akses SEMUA fitur sistem\n\nJIKA Anda merasa butuh akses fitur tapi tidak bisa buka → hubungi Admin melalui Bantuan > Laporkan Masalah kategori Masalah Akses.",
                'for_role' => 'all',
                'sort_order' => 4,
            ],
            [
                'question' => 'Mengapa nilai saya belum muncul di halaman Nilai?',
                'answer' => "Nilai Anda muncul pada halaman Nilai jika SEMUA kondisi terpenuhi:\n\n1. **Guru mata pelajaran terkait SUDAH submit** nilai melalui menu Guru > Input Nilai.\n2. **Nilai untuk Anda (baris siswa dengan nama Anda) SUDAH diisi** (bukan dibiarkan kosong).\n3. Data nilai **sudah melewati masa pemeriksaan / verifikasi Admin** (jika sekolah mengaktifkan).\n4. Semester & tahun ajaran yang Anda pilih di filter sesuai.\n5. Koneksi internet stabil (coba refresh halaman / clear cache browser).\n\nJika sudah lewat 1 minggu jadwal input nilai ditutup tapi nilai masih belum muncul:\n→ Langkah 1: Tanya terlebih dahulu ke Guru mata pelajaran terkait, apakah nilai Anda sudah diinput?\n→ Langkah 2: Jika Guru menyatakan sudah input tapi tidak muncul, lapor ke Admin melalui menu Bantuan > Laporkan Masalah kategori Data Akademik, sertakan: Mapel, Kelas, Semester, Kategori Nilai (Tugas/UTS/UAS).",
                'for_role' => 'siswa',
                'sort_order' => 5,
            ],
            [
                'question' => 'Bagaimana jika data saya (Nama, Kelas, Mapel dll) salah di sistem?',
                'answer' => "Karena data akademik dipisah oleh otoritas, ikuti langkah berikut:\n\n**Jika Anda Siswa (data Nama, Kelas, Jenis Kelamin, NISN kosong dll):**\n1. Login → buka menu Profil\n2. Coba edit dulu data yang tersedia (Nama, No HP, Alamat, Jenis Kelamin dsb) → klik Simpan\n3. Data KELAS dan NISN TIDAK BISA diubah sendiri oleh Siswa. Untuk ini, Laporkan ke Admin (Bantuan > Laporkan Masalah → kategori Data Akademik) dengan isi: Data apa yang salah, Data seharusnya apa, Lampirkan bukti (foto KK/KTP/Ijazah/Rapor).\n\n**Jika Anda Guru (data Nama, Gelar, Mapel yang diajar salah):**\n1. Login → Profil, edit dulu data yang bisa diedit\n2. Khusus MAPEL YANG DIAJAR, hubungi Admin karena menyesuaikan jadwal mengajar.\n\n**Admin akan menindaklanjuti maksimal 1 hari kerja.**",
                'for_role' => 'all',
                'sort_order' => 6,
            ],
            [
                'question' => 'Bagaimana cara menghubungi Admin sekolah?',
                'answer' => "Ada 5 channel resmi untuk menghubungi Admin:\n\n📱 **1. Tercepat: Bantuan > Laporkan Masalah (di SIAKAD)**\n   → Semua laporan OTOMATIS masuk notifikasi ikon lonceng SEMUA Admin\n   → Ada status Open > In Progress > Resolved > Closed\n   → Anda bisa lihat balasan langsung Admin di Riwayat Laporan (bawah form)\n\n📧 **2. Email Resmi Sekolah**\n   admin@sman1tuhemberua.sch.id\n\n📞 **3. WhatsApp / Nomor Resmi**\n   (Lihat pada kontak website sekolah / papan pengumuman sekolah)\n\n🏢 **4. Datang Langsung ke Ruang TU / Operator Sekolah**\n   Jam kerja: Senin-Jumat 07.00 - 15.00 WIB\n\n💬 **5. Grup WhatsApp Orang Tua / Guru**\n   Untuk pengumuman massal dan komunikasi cepat.\n\n**Prioritas tanggapan Admin:** Laporkan Masalah di sistem > Email > WhatsApp > Bertemu langsung.",
                'for_role' => 'all',
                'sort_order' => 7,
            ],
            [
                'question' => '[Admin] Bagaimana cara melakukan verifikasi akun user baru?',
                'answer' => "Langkah verifikasi user untuk Admin:\n\n1. Login akun Admin\n2. Klik ikon Lonceng (pojok kanan atas). Biasanya muncul notifikasi merah angka:\n   → Judul: Registrasi {Siswa/Guru/Kepala Sekolah} Baru\n   → Klik notifikasi tersebut → langsung pindah halaman Verifikasi Pengguna\n\nATAU manual dari Sidebar:\n3. Sidebar kiri → User & Akses → **Verifikasi Pengguna**\n4. Ada 3 tab: PENDING (user baru), ACTIVE, REJECTED, INACTIVE\n5. Klik nama user PENDING yang mau dicek → buka Detail User\n6. Periksa Data Registrasi:\n   - Role: Siswa/Guru/Kepala Sekolah?\n   - Untuk Siswa: apakah Kelas terisi, JK benar?\n   - Untuk Guru: apakah Mapel dipilih?\n7. **Aksi:**\n   ✅ Klik SETUJUI → status jadi ACTIVE → user akan dapat Notifikasi \"Akun Disetujui\" saat login\n   ❌ Klik TOLAK → isi alasan penolakan → user dapat Notifikasi \"Akun Ditolak + Alasan\"",
                'for_role' => 'admin',
                'sort_order' => 20,
            ],
            [
                'question' => '[Guru] Bagaimana cara input nilai untuk siswa saya?',
                'answer' => "Langkah Guru menginput nilai:\n\n1. Login Guru → masuk Dashboard\n2. Sidebar Akademik → menu **Nilai** (icon fa-chart-line)\n3. Pilih Filter:\n   - Kelas (X IPA 1, XI IPS 2, dst)\n   - Mata Pelajaran (Anda HANYA bisa input mapel yang diampu = tercantum di profil guru)\n   - Tahun Ajaran & Semester (Ganjil/Genap)\n   - Kategori Nilai: Tugas / UTS / UAS / Harian\n4. Klik tombol **Buka Input Nilai**\n5. Muncul tabel semua siswa di kelas tersebut.\n6. Isi nilai (0 - 100) pada kolom input di samping nama siswa. KOSONGKAN jika tidak ada nilai (tidak bisa disimpan 0 untuk siswa pindahan dsb).\n7. Klik **Simpan Semua Nilai**.\n8. Selesai! Notifikasi otomatis terkirim:\n   → Semua ADMIN dapat notif \"Nilai Baru Masuk: Kategori X Mapel Y\" untuk diverifikasi.\n   → SETIAP SISWA yang nilainya Anda isi dapat notifikasi \"Nilai Baru Tersedia\".",
                'for_role' => 'guru',
                'sort_order' => 30,
            ],
            [
                'question' => '[Guru] Bagaimana cara melihat jadwal mengajar saya?',
                'answer' => "Cara melihat jadwal mengajar untuk Guru:\n\n1. Login akun Guru.\n2. Dashboard utama biasanya menampilkan widget Jadwal Mengajar Hari Ini.\n3. Untuk lengkap: Sidebar Akademik → menu **Jadwal Pelajaran**.\n4. Tersedia tampilan:\n   • Tabel per hari (Senin s/d Jumat)\n   • Filter per Kelas, per Mapel\n   • Kolom Jam Ke, Mapel, Kelas, Ruangan\n5. Klik tombol **Download PDF** untuk menyimpan jadwal offline / dicetak.\n6. **Jika ada perubahan jadwal** (Admin menambah / edit jadwal):\n   → Anda akan dapat NOTIFIKASI di lonceng Dashboard.\n   → Judul: \"Jadwal Mengajar ditambahkan / diperbarui: {Mapel} {Kelas}\"\n   → Klik notifikasi → langsung ke halaman Jadwal.",
                'for_role' => 'guru',
                'sort_order' => 31,
            ],
            [
                'question' => '[Siswa] Bagaimana cara melihat jadwal pelajaran & unduh raport?',
                'answer' => "Panduan Siswa untuk jadwal & raport:\n\n**Melihat Jadwal Pelajaran:**\n1. Login Siswa\n2. Sidebar → menu **Jadwal Pelajaran**\n3. Tampil per hari, kelas Anda, mapel, guru pengampu, ruangan\n4. Klik Download PDF jadwal bila perlu\n5. Jika jadwal diubah Admin → Anda dapat notifikasi lonceng \"Jadwal Pelajaran ditambah/diperbarui\"\n\n**Melihat & Mengunduh Raport:**\n1. Sidebar → menu **Raport**\n2. Pilih Tahun Ajaran & Semester (Ganjil/Genap) → Tampilkan Raport\n3. Anda bisa lihat:\n   • Identitas (Nama, NIS, Kelas)\n   • Detail nilai per mapel (Tugas, UTS, UAS, Rata-rata, Bobot)\n   • Absensi (Hadir, Sakit, Ijin, Alpa)\n   • Catatan Wali Kelas\n   • Rangking kelas (bila ditampilkan sekolah)\n4. Klik tombol **Unduh Raport PDF** (icon file-download)\n5. Jika ada nilai baru diinput Guru → Anda dapat notifikasi lonceng \"Nilai Baru Tersedia\".",
                'for_role' => 'siswa',
                'sort_order' => 40,
            ],
            [
                'question' => 'Bagaimana cara logout yang benar dan aman dari SIAKAD?',
                'answer' => "Untuk keamanan AKUN & DATA PRIVASI, lakukan LOGOUT BENAR setiap selesai menggunakan SIAKAD (khusus jika memakai komputer umum / Warnet / Lab):\n\n✅ **Langkah Logout yang Benar:**\n1. Dashboard → pojok KANAN ATAS, klik **Foto Profil / Avatar Huruf** Anda → dropdown muncul.\n2. Klik menu **Keluar / Logout** (icon pintu keluar)\n3. Sistem secara OTOMATIS melakukan langkah keamanan:\n   ✔ Menghapus SEMUA session data login\n   ✔ MENGHANCURKAN ID session lama (regenerate true) agar tidak bisa dipakai kembali\n   ✔ Redirect ke halaman Login\n   ✔ Memberi Response Header NO-CACHE agar tombol BACK browser TIDAK bisa membuka dashboard dari cache\n\n⛔ **JANGAN LAKUKAN INI:**\n❌ Hanya tutup tab / tutup browser, TANPA klik Logout (session bisa tersisa beberapa menit)\n❌ Meninggalkan komputer masih dalam kondisi login\n❌ Membagikan Username / Password ke siapapun termasuk temen sekelas / sepupu",
                'for_role' => 'all',
                'sort_order' => 8,
            ],
            [
                'question' => '[Kepala Sekolah] Bagaimana cara memantau laporan akademik sekolah?',
                'answer' => "Panduan Kepala Sekolah monitoring SIAKAD:\n\n1. Login akun Kepala Sekolah.\n2. Dashboard Utama → menampilkan ringkasan:\n   - Jumlah Guru Aktif / Siswa Aktif / Total Kelas\n   - Rata-rata nilai per mapel sekolah\n   - Persentase kehadiran bulan ini\n3. Sidebar Monitoring → menu **Laporan Akademik**\n4. Filter Periode:\n   • Tahun Ajaran (2025/2026, 2026/2027)\n   • Semester (Ganjil / Genap)\n   • Filter opsional: Tingkat Kelas, Jurusan, Kelas spesifik, Mapel\n5. Klik **Tampilkan Laporan**.\n6. Fitur yang tersedia:\n   • Rekap nilai per kelas / per mapel (rata-rata, nilai tertinggi, nilai terendah, persentase ketuntasan KKM)\n   • Rekap Absensi bulanan Siswa & Guru\n   • Persentase guru yang sudah menginput nilai per kategori\n   • Ringkasan jumlah pengumuman, laporan masalah\n7. Tombol Export: **Download Excel**, **Cetak PDF** untuk rapat / laporan Dinas Pendidikan.\n8. Verifikasi Raport: Bila menu tersedia, tinjau daftar raport yang perlu tanda tangan / validasi sebelum dibagikan ke Siswa.",
                'for_role' => 'kepala_sekolah',
                'sort_order' => 50,
            ],
            [
                'question' => 'Bagaimana cara mengubah data profil dan password akun sendiri?',
                'answer' => "Setiap pengguna (Admin, Guru, Siswa, Kepala Sekolah, Tendik) dapat mengelola profilnya sendiri:\n\n**A. Mengubah Data Profil (Nama, No HP, Alamat, Foto, dll):**\n1. Login akun Anda.\n2. Klik Foto Profil / Avatar Huruf di pojok kanan atas → pilih menu **Profil**.\n3. Halaman Profil menampilkan data Anda beserta role & status akun.\n4. Klik tombol **Edit Profil** (icon fa-edit).\n5. Ubah data yang tersedia (Nama Lengkap, No HP, Alamat, Jenis Kelamin, dll).\n6. Klik **Simpan**.\n   Catatan: Data tertentu (NIP, NISN, Kelas, Mapel yang diampu) TIDAK dapat diubah sendiri oleh Siswa/Guru karena termasuk data master. Untuk koreksi, gunakan menu **Bantuan > Laporkan Masalah** kategori **Data Akademik**.\n\n**B. Mengubah Password:**\n1. Di halaman Profil, cari bagian **Ubah Password** (biasanya tab terpisah atau bawah form edit).\n2. Isi:\n   • Password LAMA (akun yang sedang login)\n   • Password BARU (minimal 8 karakter, lebih baik campuran huruf+angka)\n   • Konfirmasi Password BARU\n3. Klik **Ubah Password**.\n4. Jika berhasil → logout otomatis & Anda harus login ulang dengan password baru.\n\n**C. Jika Password LAMA lupa:**\n→ Lihat FAQ \"Bagaimana jika lupa password akun saya?\" → lakukan RESET PASSWORD oleh Admin.",
                'for_role' => 'all',
                'sort_order' => 9,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
