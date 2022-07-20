<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'login_id' => 'Rintaro',
                'name' => '岡部 倫太郎',
                'email' => 'test_01@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton01.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Mayuri',
                'name' => '椎名 まゆり',
                'email' => 'test_02@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton03.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Itaru',
                'name' => '橋田 至',
                'email' => 'test_03@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton08.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Chris',
                'name' => '牧瀬 紅莉栖',
                'email' => 'test_04@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton02.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Moeka',
                'name' => '桐生 萌郁',
                'email' => 'test_05@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton07.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Ruka',
                'name' => '漆原 るか',
                'email' => 'test_06@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton05.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Rumiho',
                'name' => '秋葉 留未穂',
                'email' => 'test_07@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton06.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
            [
                'login_id' => 'Suzuha',
                'name' => '阿万音 鈴羽',
                'email' => 'test_08@example.com',
                'image_path' => 'http://steinsgate.jp/psp/img/charaButton04.png',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
