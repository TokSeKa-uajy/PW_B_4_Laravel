# Kelas B Kelompok 4

### Anggota Kelompok:
Putu Kevin Ardiprana Nugraha (220711827) - Backend & bug hunter
Archipera Rari Dyaksa (220711891) - Home page
Tok Se Ka (220711904) - Frontend & integrasi backend

### Username & Password Login:
* Login User:
    * Username: user@gmail.com
	* Password: 12345678
* Login Admin:
	* Username: admin@gmail.com
	* Password: 12345678

### Bonus yang diambil:
* Hosting:
	* Backend: https://be.atmagym.my.id/
	* Frontend: https://atmagym.my.id/

* Routes API:
    * POST /register - Mendaftarkan akun pengguna baru
    * POST /login - Melakukan login

    * __Rute Admin (Hanya dapat diakses oleh pengguna dengan role admin):__
    * GET /admin/total - Mengambil total pengguna yang sudah mendaftar keanggotaan dan yang sudah pesan kelas
    * GET /admin/keuntungan - Menghitung dan mengambil keuntungan dari pengguna sudah mendaftar keanggotaan dan yang sudah pesan kelas
    * GET /pemesanan-all-kelas - Mengambil semua pemesanan kelas dari semua user
    * GET /registrasi-keanggotaan-admin - Mengambil semua data registrasi keanggotaan dari user

    * POST /pelatih - Menambahkan pelatih baru
    * GET /pelatih/{id} - Mengambil data pelatih berdasarkan id  
    * POST /pelatih/{id} - Memperbarui data pelatih  
    * DELETE /pelatih/{id} - Menghapus pelatih  

    * POST /kategori-kelas - Membuat kategori kelas baru  
    * GET /kategori-kelas/{id} - Mengambil data kategori kelas berdasarkan id  
    * PUT /kategori-kelas/{id} - Memperbarui data kategori kelas  
    * DELETE /kategori-kelas/{id} - Menghapus kategori kelas  

    * POST /paket-keanggotaan - Membuat paket keanggotaan baru  
    * GET /paket-keanggotaan/{id} - Mengambil data paket keanggotaan berdasarkan id  
    * PUT /paket-keanggotaan/{id} - Memperbarui data paket keanggotaan  
    * DELETE /paket-keanggotaan/{id} - Menghapus paket keanggotaan  

    * GET /paket-kelas/{idKelas} - Mengambil semua data kelas yang berhubungan dengan paket  
    * POST /paket-kelas - Menambahkan paket kelas baru  
    * GET /paket-kelas/{id} - Mengambil data paket kelas berdasarkan id  
    * PUT /paket-kelas/{id} - Memperbarui paket kelas  
    * DELETE /paket-kelas/{id} - Menghapus paket kelas  

    * POST /kelas - Membuat kelas baru  
    * GET /kelas/{id} - Mengambil data kelas berdasarkan id  
    * PUT /kelas/{id} - Memperbarui data kelas  
    * DELETE /kelas/{id} - Menghapus kelas  

    * __Rute Pengguna (Hanya dapat diakses oleh pengguna dengan role user):__
    * GET /kelas-user - Mengambil semua kelas untuk pengguna reguler  
    * GET /kategori-kelas-user - Menampilkan semua kategori kelas untuk pengguna reguler  
    * GET /paket-kelas/cari/{id} - Mengambil kelas yang berhubungan dengan id paket tertentu yang tersedia untuk pengguna reguler  

    * GET /pemesanan-kelas/cari/{id} - Mengambil data pemesanan kelas berdasarkan id pengguna reguler  
    * GET /pemesanan-kelas - Mengambil data semua pemesanan kelas untuk pengguna reguler  
    * POST /pemesanan-kelas - Melakukan pemesanan kelas baru  
    * GET /pemesanan-kelas/{id} - Mengambil data pemesanan kelas berdasarkan id pemesanan  
    * GET /pemesanan-kelas-user - Menampilkan semua pemesanan kelas yang dilakukan oleh pengguna  

    * POST /registrasi-keanggotaan - Mendaftar untuk keanggotaan  
    * GET /registrasi-keanggotaan-checkStatus - Memeriksa apakah pengguna reguler memiliki status keanggotaan  
    * GET /registrasi-keanggotaan - Menampilkan semua pendaftaran keanggotaan  
    * GET /registrasi-keanggotaan-user - Mengambil data pendaftaran keanggotaan berdasarkan id pengguna  

    * POST /keanggotaan - Menyimpan data setelah mendaftar untuk keanggotaan baru  
    * GET /keanggotaan - Menampilkan data keanggotaan pengguna  

    * POST /umpan-balik - Mengirim umpan balik dari kelas yang sudah dipesan  
    * GET /umpan-balik/{id} - Mengambil data umpan balik berdasarkan id  
    * PUT /umpan-balik/{id} - Memperbarui data umpan balik  
    * DELETE /umpan-balik/{id} - Menghapus umpan balik  

    * __Rute Umum (Dapat diakses oleh semua pengguna yang login):__
    * GET /user/profile - Mengambil informasi profil pengguna  
    * POST /user/update-profile - Memperbarui data profil pengguna  

    * POST /logout - Melakukan logout  

    * GET /kelas - Menampilkan semua kelas  
    * GET /kategori-kelas - Menampilkan semua kategori kelas  
    * GET /umpan-balik - Menampilkan semua entri umpan balik  
    * GET /paket-keanggotaan-user - Menampilkan semua paket keanggotaan yang tersedia untuk pengguna  
    * GET /paket-kelas-admin - Menampilkan semua paket kelas  
    * GET /pelatih - Menampilkan semua pelatih  

* React: 
	* Link Repository: https://github.com/TokSeKa-uajy/PW_B_4_React.git
