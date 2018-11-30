# Tugas 2 IF3110 Pengembangan Aplikasi Berbasis Web 

Melakukan *upgrade* Website toko buku online pada Tugas 1 dengan mengaplikasikan **arsitektur web service REST dan SOAP**.

### Tujuan Pembuatan Tugas

Luaran dari tugas ini adalah memahami poin-poin berikut:
* Produce dan Consume REST API
* Produce dan Consume Web Services dengan protokol SOAP
* Membuat web application yang akan memanggil web service secara REST dan SOAP.
* Memanfaatkan web service eksternal (API)

## Anggota Tim

* Rizki Alif Salman Alfarisy - 13516005
* Renjira Naufhal Dhiaegana - 13516014
* Naufal Putra Pamungkas - 13516110

## Penjelasan
1.  Basis Data
    Kami memiliki dua database yang telah dibuat dan satu database yang di modifikasi: **probank**, **bookservice**, dan **probook** secara urut. 

* Database **probank** memiliki dua tabel relasi, yaitu *nasabah* dan *transaksi* :
    
    * Tabel *nasabah* memiliki 3 kolom : 
        * nama : sebagai nama nasabah yang terdaftar pada probank
        * nomor : sebagai nomor kartu nasabah yang terdaftar pada probank (**PRIMARY KEY**)
        * saldo : sebagai nominal uang yang dimiliki nasabah
        
    * Tabel *transaksi* memiliki 4 kolom : 
        * pengirim : sebagai nomor nasabah pengirim yang melakukan transaksi (**FOREIGN KEY => NASABAH.NOMOR**)
        * penerima : sebagai nomor nasabah penerima transaksi pengiriman (**FOREIGN KEY => NASABAH.NOMOR**)
        * jumlah : sebagai nominal uang yang dikirim dari pengirim ke penerima
        * waktu : sebagai waktu dilakukannya transaksi
        

* Database **bookservice** memiliki dua tabel relasi, yaitu *buku* dan *transaksi* :
    
    * Tabel *buku* memiliki 3 kolom : 
        * id : sebagai id buku yang masih memiliki stok pada toko probook (**PRIMARY KEY**)
        * price : sebagai harga buku
        
    * Tabel *transaksi* memiliki 4 kolom : 
        * id : sebagai id buku yang sudah memiliki transaksi (**FOREIGN KEY => BUKU.ID**)
        * amount : sebagai jumlah buku
        * categories : sebagai kategori buku
        
* Database **probook** memiliki dua tiga relasi, yaitu *order*, *user* dan *token* :
    
    * Tabel *order* memiliki 7 kolom : 
        * amount : sebagai jumlah buku yang dibeli pada pemesanan
        * book : sebagai id buku
        * buyer : sebagai username pengirim (**FOREIGN KEY => USER.USERNAME**)
        * idorder : sebagai id pemesanan(order) buku (**PRIMARY KEY**)
        * order_date : sebagai tanggal pemesanan
        * rating : sebagai nilai rating yang diberikan oleh pemesan
        * review : deskripsi ulasan yang diberikan pemesan
        
    * Tabel *token* memiliki 5 kolom : 
        * access_token : sebagai token yang di-generate oleh probook ketika user login (**PRIMARY KEY**)
        * browser : jenis browser yang digunakan ketika access token dibuat
        * expiry_time : waktu expire sebuah token
        * granted : username pengguna yang diberikan token (**FOREIGN KEY => USER.USERNAME**)
        * ip : ip address user ketika login
        
    * Tabel *user* memiliki 5 kolom : 
        * address : alamat dari pemilik akun probook
        * card_number : nomor kartu bank pemilik akun probook
        * email : alamat email dari pemilik akun probook 
        * name : name dari pemilik akun probook
        * password : password dari pemilik akun probook
        * phone : nomor telepon dari pemilik akun probook
        * picture : picture dari pemilik akun probook
        * username :username dari pemilik akun probook (**PRIMARY KEY**)

2.  Konsep *shared session* dengan REST
REST : Respresentational State Transfer
REST adalah sebuah konsep dalam melakukan shared session / state transfer (karena Web itu stateless)
REST biasanya diimplementasikan di HTTP (biarpun bisa di teknologi yg lain juga)

Konsep :
- resource / sumber daya logical (berbentuk kelas biasanya)
- server : tempat menampung sumberdaya
- client : yang melakukan request pada server
- request dan response : interaksi antara client dan server
- representation : dokumen yg menjelaskan status dari sebuah resource

Prinsip
1. State dari resource diketahui hanya oleh internal dari server
2. Server tidak memiliki status dari client
3. Request dari client mengandung semua informasi untuk diproses server
4. Session state di store di client side
5. Resource bisa memiliki beberapa respresentation
6. Response mengindikasikan cacheability (bisa ketahuan perlu di cached atau tidak)
7. Opsional : client bisa fetch sebagian code server jika dibutuhkan

sumber: https://www.javacodegeeks.com/2012/10/introduction-to-rest-concepts.html

3. Mekanisme pembangkitan token dan expiry time
    Berikut tahapan yang kami lakukan untuk melakukan pembangkitan token dan expiry time:
* Ketika user melakukan login atau register maka user akan diberikan string random sebagai akses token yang memiliki expire time sejam dari login.
* Akses token dipasangkan ke satu user, ip address, dan browser kemudian disimpan di *database*
* Pada setiap login, setelah menambahkan access token database juga akan menghapus token-token yang sudah expire
* Jika pengguna melakukan logut, maka access token yang dimiliki pengguna terhadap browser dan ip address tempat logout akan dihapus

4. Kelebihan dan kelemahan dari arsitektur
 Kelebihan :
- Aplikasi dapat dikembangkan secara modular
- Kegagalan sistem pada salah satu service tidak akan menyebabkan kegagalan total pada aplikasi
- Dapat diaplikasikan di sistem terdistribusi

Kekurangan :
- Rentan terhadap *bottleneck* jika terjadi traffic tingkat tinggi pada salah satu server

### Deskripsi Tugas
![](temp/architecture.png)

Pada tugas 2, Anda diminta untuk mengembangkan aplikasi toko buku online sederhana yang sudah Anda buat pada tugas 1. Arsitektur aplikasi diubah agar memanfaatkan 2 buah webservice, yaitu webservice bank dan webservice buku. Baik aplikasi maupun kedua webservice, masing-masing memiliki database sendiri. Jangan menggabungkan ketiganya dalam satu database. Anda juga perlu mengubah beberapa hal pada aplikasi pro-book yang sudah Anda buat.

#### Webservice bank

Anda diminta membuat sebuah webservice bank sederhana yang dibangun di atas **node.js**. Webservice bank memiliki database sendiri yang menyimpan informasi nasabah dan informasi transaksi. Informasi nasabah berisi nama, nomor kartu, dan saldo. Informasi transaksi berisi nomor kartu pengirim, nomor kartu penerima, jumlah, dan waktu transaksi. Informasi lain yang menurut Anda dibutuhkan silahkan ditambahkan sendiri. Database webservice bank harus terpisah dari database aplikasi pro-book.

Webservice bank menyediakan service untuk validasi nomor kartu dan transfer. Webservice bank diimplementasikan menggunakan protokol **REST**.
- Service validasi nomor kartu dilakukan dengan memeriksa apakah nomor kartu tersebut ada pada database bank. Jika iya, berarti kartu tersebut valid.
  
- Service transfer menerima input nomor kartu pengirim, penerima, dan jumlah yang ditransfer. Jika saldo mencukupi, maka transfer berhasil dan uang sejumlah tersebut dipindahkan dari pengirim ke penerima. Transaksi tersebut juga dicatat dalam database webservice. Jika saldo tidak mencukupi, maka transaksi ditolak dan tidak dicatat di database.
  
#### Webservice buku

Webservice ini menyediakan daftar buku beserta harganya yang akan digunakan oleh aplikasi pro-book. Webservice buku dibangun di atas **java servlet**. Service yang disediakan webservice ini antara lain adalah pencarian buku, mengambil detail buku, melakukan pembelian, serta memberikan rekomendasi buku sederhana. Webservice ini diimplementasikan menggunakan **JAX-WS dengan protokol SOAP**.

Webservice ini memanfaatkan **Google Books API melalui HttpURLConnection. Tidak diperbolehkan menggunakan Google Books Client Library for Java**. Data-data buku yang dimiliki oleh webservice ini akan mengambil dari Google Books API. Silahkan membaca [dokumentasinya](https://developers.google.com/books/docs/overview) untuk detail lebih lengkap. Data pada Google Books API tidak memiliki harga, maka webservice buku perlu memiliki database sendiri berisi data harga buku-buku yang dijual. Database webservice buku harus terpisah dari database bank dan dari database aplikasi pro-book.

Detail service yang disediakan webservice ini adalah:

- Pencarian buku menerima keyword judul. Keyword ini akan diteruskan ke Google Books API dan mengambil daftar buku yang mengandung keyword tersebut pada judulnya. Hasil tersebut kemudian dikembalikan pada aplikasi setelah diproses. Proses yang dilakukan adalah menghapus data yang tidak dibutuhkan, menambahkan harga buku jika ada di database, dan mengubahnya menjadi format SOAP.

- Pengambilan detail juga mengambil data dari Google Books API, seperti service search. Baik service ini maupun search, informasi yang akan dikembalikan hanya informasi yang dibutuhkan. Jangan lansung melemparkan semua data yang didapatkan dari Google Books API ke aplikasi. Karena pengambilan detail buku menggunakan ID buku, maka ID buku webservice harus mengikuti ID buku Google Books API. Pada service ini, harga buku juga dicantumkan.

- Webservice ini menangani proses pembelian. Service ini menerima masukan id buku yang dibeli, jumlah yang dibeli, serta nomor rekening user yang membeli buku. Nomor rekening tersebut akan digunakan untuk mentransfer uang sejumlah harga total buku. Jika transfer gagal, maka pembelian buku juga gagal.

  Jumlah buku yang berhasil dibeli dicatat di database. Webservice menyimpan ID buku, kategori (genre), dan jumlah total pembelian buku tersebut. Data ini akan digunakan untuk memberikan rekomendasi. Jika pembelian gagal maka data tidak dicatat pada aplikasi.

- Webservice juga dapat memberikan rekomendasi sederhana. Input dari webservice ini adalah kategori buku. Kategori buku yang dimasukkan boleh lebih dari 1. Buku yang direkomendasikan adalah buku yang memiliki jumlah pembelian total terbanyak yang memiliki kategori yang sama dengan daftar kategori yang menjadi input. Data tersebut didapat dari service yang mencatat jumlah pembelian.
  
  Jika buku dengan kategori tersebut belum ada yang terjual, maka webservice akan mengembalikan 1 buku random dari hasil pencarian pada Google Books API. Pencarian yang dilakukan adalah buku yang memiliki kategori yang sama dengan salah satu dari kategori yang diberikan (random).
  
#### Perubahan pada aplikasi pro-book

Karena memanfaatkan kedua webservice tersebut, akan ada perubahan pada aplikasi yang Anda buat.

- Setiap user menyimpan informasi nomor kartu yang divalidasi menggunakan webservice bank. Validasi dilakukan ketika melakukan registrasi atau mengubah informasi nomor kartu. Jika nomor kartu tidak valid, registrasi atau update profile gagal dan data tidak berubah.

- Data buku diambil dari webservice buku, sehingga aplikasi tidak menyimpan data buku secara lokal. Setiap kali aplikasi membutuhkan informasi buku, aplikasi akan melakukan request kepada webservice buku. Hal ini termasuk proses search dan melihat detail buku.

  Database webservice cukup menyimpan harga sebagian buku yang ada di Google Books API. Buku yang harganya tidak Anda definisikan di database boleh dicantumkan NOT FOR SALE dan tidak bisa dibeli, tetapi tetap bisa dilihat detailnya.

- Proses pembelian buku pada aplikasi ditangani oleh webservice buku. Status pembelian (berhasil/gagal dan alasannya) dilaporkan kepada user dalam bentuk notifikasi. Untuk kemudahan, tidak perlu ada proses validasi dalam melakukan transfer

- Pada halaman detail buku, terdapat rekomendasi buku yang didapatkan dari webservice buku. Asumsikan sendiri tampilan yang sesuai.

- Halaman search-book dan search-result pada tugas 1 digabung menjadi satu halaman search yang menggunakan AngularJS. Proses pencarian buku diambil dari webservice buku menggunakan **AJAX**. Hasil pencarian akan ditampilkan pada halaman search menggunakan AngularJS, setelah mendapatkan respon dari webservice. Ubah juga tampilan saat melakukan pencarian untuk memberitahu jika aplikasi sedang melakukan pencarian atau tidak ditemukan hasil.

- Aplikasi Anda menggunakan `access token` untuk menentukan active user. Mekanisme pembentukan dan validasi access token dapat dilihat di bagian *Mekanisme access token*.

#### Mekanisme access token
`Access token` berupa string random. Ketika user melakukan login yang valid, sebuah access token di-generate, disimpan dalam database server, dan diberikan kepada browser. Satu `access token` memiliki `expiry time` token (berbeda dengan expiry time cookie) dan hanya dapat digunakan pada 1 *browser/agent* dari 1 *ip address* tempat melakukan login. Sebuah access token mewakilkan tepat 1 user. Sebuah access token dianggap valid jika:
- Access token terdapat pada database server dan dipasangkan dengan seorang user.
- Access token belum expired, yaitu expiry time access token masih lebih besar dari waktu sekarang.
- Access token digunakan oleh browser yang sesuai.
- Access token digunakan dari ip address yang sesuai.

Jika access token tidak ada atau tidak valid, maka aplikasi melakukan *redirect* ke halaman login jika user mengakses halaman selain login atau register. Jika access token ada dan valid, maka user akan di-*redirect* ke halaman search jika mengakses halaman login. Fitur logout akan menghapus access token dari browser dan dari server.

#### Catatan

Hal-hal detail yang disebutkan pada spesifikasi di atas seperti data yang disimpan di database, parameter request, dan jenis service yang disediakan adalah spesifikasi minimum yang harus dipenuhi. Anda boleh menambahkan data/parameter/service lain yang menurut Anda dibutuhkan oleh aplikasi atau web service lainnya. Jika Anda ingin mengubah data/parameter/service yang sudah disebutkan di atas, Anda wajib mempertanggung jawabkannya dan memiliki argumen yang mendukung keputusan tersebut.

### Skenario

1. User melakukan registrasi dengan memasukkan informasi nomor kartu.
2. Jika nomor kartu tidak valid, registrasi ditolak dan user akan diminta memasukkan kembali nomor kartu yang valid.
3. User yang sudah teregistrasi dapat mengganti informasi nomor kartu.
4. Ketika user mengganti nomor kartu, nomor kartu yang baru akan diperiksa validasinya melalui webservice bank.
5. Setelah login, user dapat melakukan pencarian buku.
6. Pencarian buku akan mengirim request ke webservice buku. Halaman ini menggunakan AngularJS.
7. Pada halaman detail buku, ada rekomendasi buku yang didapat dari webservice buku. Rekomendasi buku berdasarkan kategori buku yang sedang dilihat.
8. Ketika user melakukan pemesanan buku, aplikasi akan melakukan request transfer kepada webservice bank.
9. Jika transfer berhasil, aplikasi mengirimkan request kepada webservice buku untuk mencatat penjualan buku.
10. Notifikasi muncul menandakan status pembelian, berhasil atau gagal.

### Pembagian Tugas
"Gaji buta dilarang dalam tugas ini. Bila tak mengerti, luangkan waktu belajar lebih banyak. Bila belum juga mengerti, belajarlah bersama-sama kelompokmu. Bila Anda sekelompok bingung, bertanyalah (bukan menyontek) ke teman seangkatanmu. Bila seangkatan bingung, bertanyalah pada asisten manapun."

REST :
1. Validasi nomor kartu : 13516110
2. Menghubungkan Webservice bank dan Webservice buku dengan method post (Transfer) : 13516014
3. Menghubungkan Client ke webservice bank untuk memanggil fungsional validasi : 13516005

SOAP :
1. Fungsionalitas buyBookByID : 13516005, 13516014
2. Fungsionalitas connectHttpUrl for GET and POST : 13516014
3. Fungsionalitas getConnectionResponse : 13516014
4. Fungsionalitas getRecommendation : 13516005, 13516110
5. Fungsionalitas getBook : 13516005
6. Fungsionalitas searchBook : 13516005

Perubahan Web app :
1. Halaman Search : 13516110
2. Halaman Detail : 13516005, 13516014, 13516110
3. Halaman Register : 13516005, 13516110
4. Halaman Edit Profile : 13516005, 13516110

Bonus :
1. Pembangkitan token HTOP/TOTP : 
2. Validasi token : 

## About

Asisten IF3110 2018

Audry | Erick | Holy | Kevin J. | Tasya | Veren | Vincent H.

Dosen : Yudistira Dwi Wardhana | Riza Satria Perdana | Muhammad Zuhri Catur Candra

