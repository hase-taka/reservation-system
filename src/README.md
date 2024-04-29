# reservation-system

## 概要説明

<img width="800" alt="スクリーンショット 2024-04-29 23 47 41" src="https://github.com/hase-taka/attendance-system/assets/148784913/5dfda12a-88a8-4f12-83f7-ea1191628bcb">

<img width="800" alt="スクリーンショット 2024-04-29 23 47 07" src="https://github.com/hase-taka/attendance-system/assets/148784913/bbaa608b-9837-4105-b757-300b42098333">

飲食店の予約サービスを作成いたしました。

## 作成目的

企業から自社自社で予約サービスを持ちたいと依頼を受けたため。
自社のサービスを持つことで手数料を削減することができる。

## アプリケーション URL

-   <>

## 機能一覧

-   会員登録
-   ログイン・ログアウト
-   ユーザー情報取得
-   ユーザー飲食店お気に入り一覧取得
-   ユーザー飲食店予約情報取得
-   飲食店一覧取得
-   飲食店詳細取得
-   飲食店お気に入り追加
-   飲食店お気に入り削除
-   飲食店予約情報追加
-   飲食店予約情報削除
-   エリアで検索する
-   ジャンルで検索する
-   店名で検索する
-   stripe を利用し、カード決済
-   予約日の朝にリマインダーメール送信
-   管理者から利用者へのメール送信
-   予約の QR コード作成
-   店舗ごとの予約情報一覧
-   認証と予約時の Form Request によるバリデーション
-   My_page から予約の変更
-   評価機能（レビュー）
-   飲食店舗の追加、コース設定（店舗代表のみ）
-   飲食店舗の編集、コースの編集（店舗代表のみ）
-   ユーザの一覧（管理者のみ）
-   ユーザの権限変更（管理者のみ）

## 使用技術

-   PHP 7.49
-   Laravel 8.83.8
-   Mysql 8.0.26

## テーブル設計

<img width="800" alt="スクリーンショット 2024-04-29 23 00 53" src="https://github.com/hase-taka/attendance-system/assets/148784913/6afe7b5d-ff2c-4524-929d-996d8e2d9d86">

## ER 図

<img width="800" alt="スクリーンショット 2024-04-27 1 28 39" src="https://github.com/hase-taka/attendance-system/assets/148784913/a7cad675-862c-4a5c-b1f8-5d7a48b99422">

## 環境構築

Docker ビルド

1. git clone
2. docker-compose up -d --build

Laravel 環境構築

1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから.env ファイルを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
7. php artisan schedule:work

## URL

-   開発環境:<http://localhost/>
-   phpMyAdmin:<http://localhost:8080/>

##

-   test user として admin(管理者)、representative(店舗代表)、user(利用者)を用意しました。パスワードはすべて「password」と設定しています。

1. admin mail:a@a
2. representative mail:b@b
3. user mail:c@c
