<?php

namespace Database\Seeders;

// use App\Models\pegawai;
// use App\Models\member;
 use App\Models\jadwal_umum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pegawai::create([
        //     'id' =>'000.00.001',
        //     'id_role' => '1',
        //     'nama_pegawai' => 'Rafael',
        //     'alamat_pegawai' => 'jl babarsari no. 10',
        //     'no_telepon' => '08794561230',
        //     'tanggal_lahir' => '14 Oktober 1920',
        //     'email_pegawai' => 'Rafaelnager13@gmail.com',
        //     'username' => 'Manager',
        //     'password' => Hash::make('manager'),
        // ]);

        // Pegawai::create([
        //     'id' =>'000.00.002',
        //     'id_role' => '2',
        //     'nama_pegawai' => 'Richado',
        //     'alamat_pegawai' => 'jl Kledokan no.03',
        //     'no_telepon' => '08797896523',
        //     'tanggal_lahir' => '15 Februari 1999',
        //     'email_pegawai' => 'Richado10@gmail.com',
        //     'username' => 'Admin',
        //     'password' => Hash::make('admin'),
        // ]);

        // Pegawai::create([
        //     'id' =>'000.00.003',
        //     'id_role' => '3',
        //     'nama_pegawai' => 'Lisa',
        //     'alamat_pegawai' => 'jl Senturan no.60',
        //     'no_telepon' => '08799645321',
        //     'tanggal_lahir' => '16 Mei 2000',
        //     'email_pegawai' => 'Lisa15@gmail.com',
        //     'username' => 'Kasir',
        //     'password' => Hash::make('kasir'),
        // ]);

        // promo::create([
        //     'id' =>'1',
        //     'nama_promo' => 'deposit_uang',
        //     'minimal_pembelian' => '3000000',
        //     'bonus' => '300000'
        // ]);

        // promo::create([
        //     'id' =>'2',
        //     'nama_promo' => 'Paket 5 + 1',
        //     'minimal_pembelian' => '5',
        //     'bonus' => '1'
        // ]);

        // promo::create([
        //     'id' =>'3',
        //     'nama_promo' => 'Paket 10 + 3',
        //     'minimal_pembelian' => '10',
        //     'bonus' => '3'
        // ]);

        // kelas::create([
        //     'id' =>'1',
        //     'nama_kelas' => 'SPINE Corrector',
        //     'harga_kelas' => '150000'
        // ]);

        // kelas::create([
        //     'id' =>'2',
        //     'nama_kelas' => 'MUAYTHAI',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'3',
        //     'nama_kelas' => 'PILATES',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'4',
        //     'nama_kelas' => 'ASTHANGA',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'5',
        //     'nama_kelas' => 'Body Combat',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'6',
        //     'nama_kelas' => 'ZUMBA',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'7',
        //     'nama_kelas' => 'HATHA',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'8',
        //     'nama_kelas' => 'Wall Swing',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'9',
        //     'nama_kelas' => 'Basic Swing',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'10',
        //     'nama_kelas' => 'Bellydance',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'11',
        //     'nama_kelas' => 'BUNGGE*',
        //     'harga_kelas' => '200000'
        // ]);
        // kelas::create([
        //     'id' =>'12',
        //     'nama_kelas' => 'Yogalates',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'13',
        //     'nama_kelas' => 'BOXING',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'14',
        //     'nama_kelas' => 'Calisthenics',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'15',
        //     'nama_kelas' => 'Pound Fit',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'16',
        //     'nama_kelas' => 'Trampoline Workout*',
        //     'harga_kelas' => '200000'
        // ]);
        // kelas::create([
        //     'id' =>'17',
        //     'nama_kelas' => 'Yoga For Kids',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'18',
        //     'nama_kelas' => 'Abs Pilates',
        //     'harga_kelas' => '150000'
        // ]);
        // kelas::create([
        //     'id' =>'19',
        //     'nama_kelas' => 'Swing For Kids',
        //     'harga_kelas' => '150000'
        // ]);
        
        // instruktur::create([
        //     'id' => '1',
        //     'nama_instruktur' => 'Joon',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '18 Januari 1998',
        //     'email' => 'joon@gmail.com',
        //     'username' => 'Joon', 
        //     'password' => Hash::make('password')
        // ]);
        // instruktur::create([
        //     'id' => '2',
        //     'nama_instruktur' => 'JK',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '13 Januari 1998',
        //     'email' => 'jk1201@gmail.com',
        //     'username' => 'JK', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '3',
        //     'nama_instruktur' => 'Lisa',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '10 Mei 1998',
        //     'email' => 'lisa@gmail.com',
        //     'username' => 'Lisa', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '4',
        //     'nama_instruktur' => 'Hobby',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '11 Januari 1998',
        //     'email' => 'hobby@gmail.com',
        //     'username' => 'Hobby', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '5',
        //     'nama_instruktur' => 'V',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '12 Februari 1989',
        //     'email' => 'v1201@gmail.com',
        //     'username' => 'V1201', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '6',
        //     'nama_instruktur' => 'Jenny',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '12 Februari 1989',
        //     'email' => 'jenny@gmail.com',
        //     'username' => 'Jenny', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '7',
        //     'nama_instruktur' => 'Suga',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '3 April 2000',
        //     'email' => 'suga@gmail.com',
        //     'username' => 'Suga', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '8',
        //     'nama_instruktur' => 'Rose',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '3 Juni 1992',
        //     'email' => 'rose@gmail.com',
        //     'username' => 'Rose', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '9',
        //     'nama_instruktur' => 'Jin',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '18 November 1981',
        //     'email' => 'jin1301@gmail.com',
        //     'username' => 'Jin', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '10',
        //     'nama_instruktur' => 'Jisoo',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '14 Desember 1982',
        //     'email' => 'jisoo13@gmail.com',
        //     'username' => 'Jisoo', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '11',
        //     'nama_instruktur' => 'Jimin',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '18 September 1986',
        //     'email' => 'jimin1301@gmail.com',
        //     'username' => 'Jimin', 
        //     'password' => Hash::make('password')
        // ]);

        // instruktur::create([
        //     'id' => '12',
        //     'nama_instruktur' => 'Jessi',
        //     'alamat_instruktur' => 'Babarsari',
        //     'no_telepon' => '0879456123054',
        //     'tanggal_lahir' => '3 Januari 1982',
        //     'email' => 'jessi13@gmail.com',
        //     'username' => 'Jessi', 
        //     'password' => Hash::make('password')
        // ]);
        
        jadwal_umum::create([
            'id' => '1',
            'id_kelas' => '1',
            'id_instruktur' => '1',
            'hari' => 'Monday',
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '2',
            'id_kelas' => '2',
            'id_instruktur' => '2',
            'hari' => 'Monday',
            'sesi_kelas' => '09:30',
        ]);

        jadwal_umum::create([
            'id' => '3',
            'id_kelas' => '3',
            'id_instruktur' => '3',
            'hari' => "Tuesday",
            'sesi_kelas' => '08:00',
        ]);
        jadwal_umum::create([
            'id' => '4',
            'id_kelas' => '4',
            'id_instruktur' => '4',
            'hari' => "Tuesday",
            'sesi_kelas' => '09:30',
        ]);

        jadwal_umum::create([
            'id' => '5',
            'id_kelas' => '5',
            'id_instruktur' => '5',
            'hari' => "Wednesday",
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '6',
            'id_kelas' => '6',
            'id_instruktur' => '6',
            'hari' => "Wednesday",
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '7',
            'id_kelas' => '7',
            'id_instruktur' => '7',
            'hari' => "Wednesday",
            'sesi_kelas' => '09:30',
        ]);

        jadwal_umum::create([
            'id' => '8',
            'id_kelas' => '8',
            'id_instruktur' => '8',
            'hari' => "Thuesday",
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '9',
            'id_kelas' => '9',
            'id_instruktur' => '9',
            'hari' => "Thuesday",
            'sesi_kelas' => '09:30',
        ]);

        jadwal_umum::create([
            'id' => '10',
            'id_kelas' => '7',
            'id_instruktur' => '9',
            'hari' => "Friday",
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '11',
            'id_kelas' => '10',
            'id_instruktur' => '10',
            'hari' => "Friday",
            'sesi_kelas' => '09:30',
        ]);
        jadwal_umum::create([
            'id' => '12',
            'id_kelas' => '11',
            'id_instruktur' => '11',
            'hari' => "Saturday",
            'sesi_kelas' => '08:00',
        ]);

        jadwal_umum::create([
            'id' => '13',
            'id_kelas' => '12',
            'id_instruktur' => '3',
            'hari' => "Saturday",
            'sesi_kelas' => '09:30',
        ]);
        
        jadwal_umum::create([
            'id' => '14',
            'id_kelas' => '13',
            'id_instruktur' => '2',
            'hari' => "Saturday",
            'sesi_kelas' => '09:30',
        ]);

        jadwal_umum::create([
            'id' => '15',
            'id_kelas' => '14',
            'id_instruktur' => '1',
            'hari' => "Sunday",
            'sesi_kelas' => '09:00',
        ]);

        jadwal_umum::create([
            'id' => '16',
            'id_kelas' => '10',
            'id_instruktur' => '10',
            'hari' => "Monday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '17',
            'id_kelas' => '15',
            'id_instruktur' => '4',
            'hari' => "Monday",
            'sesi_kelas' => '18:30',
        ]);

        jadwal_umum::create([
            'id' => '18',
            'id_kelas' => '14',
            'id_instruktur' => '1',
            'hari' => "Tuesday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '19',
            'id_kelas' => '1',
            'id_instruktur' => '7',
            'hari' => "Tuesday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '20',
            'id_kelas' => '16',
            'id_instruktur' => '8',
            'hari' => "Tuesday",
            'sesi_kelas' => '18:30',
        ]);

        jadwal_umum::create([
            'id' => '21',
            'id_kelas' => '17',
            'id_instruktur' => '12',
            'hari' => "Wednesday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '22',
            'id_kelas' => '9',
            'id_instruktur' => '9',
            'hari' => "Wednesday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '23',
            'id_kelas' => '11',
            'id_instruktur' => '11',
            'hari' => "Wednesday",
            'sesi_kelas' => '18:30',
        ]);

        jadwal_umum::create([
            'id' => '24',
            'id_kelas' => '18',
            'id_instruktur' => '6',
            'hari' => "Thuesday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '25',
            'id_kelas' => '5',
            'id_instruktur' => '5',
            'hari' => "Thuesday",
            'sesi_kelas' => '18:30',
        ]);

        jadwal_umum::create([
            'id' => '26',
            'id_kelas' => '6',
            'id_instruktur' => '6',
            'hari' => "Friday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '27',
            'id_kelas' => '2',
            'id_instruktur' => '2',
            'hari' => "Friday",
            'sesi_kelas' => '18:30',
        ]);
        jadwal_umum::create([
            'id' => '28',
            'id_kelas' => '19',
            'id_instruktur' => '12',
            'hari' => "Saturday",
            'sesi_kelas' => '17:00',
        ]);

        jadwal_umum::create([
            'id' => '29',
            'id_kelas' => '11',
            'id_instruktur' => '11',
            'hari' => "Saturday",
            'sesi_kelas' => '17:00',
        ]);
        
        jadwal_umum::create([
            'id' => '30',
            'id_kelas' => '16',
            'id_instruktur' => '8',
            'hari' => "Saturday",
            'sesi_kelas' => '18:30',
        ]);

    }
}
