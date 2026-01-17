# バックエンド（Laravel API） - 飲食店注文アプリ

Laravel と MySQL で作られた API サーバーです。  
注文管理、メニュー管理、ユーザー認証を担当します。

## 前提条件

-   Docker / Docker Compose
-   PHP >= 8
-   Composer

## 環境構築

1. リポジトリをクローン

    ```bash
    git clone https://github.com/risa-prog/restaurant-app-backend.git
    cd restaurant-app-backend


    ```

2. Docker を立ち上げ

    ```bash
    docker-compose up -d


    ```

3. コンテナに入る

    ```bash
    docker-compose exec app bash


    ```

4. 依存パッケージをインストール

    ```bash
    composer install


    ```

5. 環境設定

    ```bash
    cp .env.example .env
    php artisan key:generate

    ```

6. DB マイグレーションとシーディング

    ```bash
    php artisan migrate
    php artisan db:seed


    ```

7. ストレージリンク作成
    ```bash
    php artisan storage:link

    ```

## 主な機能
-	API 認証（Laravel Sanctum）
-	注文管理
-	メニュー管理
-	ユーザー管理

## 技術スタック
-	Laravel 12
-	Sanctum（API 認証）
-	MySQL 8
-	Docker / Docker Compose
-	Composer ライブラリ

## ER図
![ER図](docs/restaurant-app-backend-ER.drawio.png)

## ディレクトリ構成について

Laravel プロジェクト本体は `src` ディレクトリ配下に配置されています。  
構成としては一般的ではありませんが、動作確認済みであり、本ポートフォリオでは現状の構成を採用しています。
