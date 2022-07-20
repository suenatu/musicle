# 環境構築手順

## 環境構築手順
以下のコマンドをプロジェクトフォルダで実行する。
```
# 環境設定ファイル作成
cp .env.example .env
```
```
# Composerパッケージインストール
composer install
```
```
# npmパッケージインストール
npm install
```
```
# マイグレーション実行
php artisan migrate:refresh --seed
```
