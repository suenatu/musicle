# musicle

## 環境構築(Docker)

### Windows
#### **WSL2の有効化**
1. 管理者コマンドプロンプトを起動
2. WSL2を有効にする(以下を入力)<br>
    `> wsl --install` (インストールされるディストリビューションはUbuntu)<br>
    `> wsl --install -d <ディストリビューション名>`<br>
    (ディストリビューションを指定したい場合は→ `> wsl --list --online` でインストールできるディストリビューションが表示される)
3. 再起動(指示される)
4. Ubuntu(もしくは自分で指定したディストリビューション)の起動、ユーザー名・パスワード登録

#### **Dokcer Desktopのインストール**
1. [Docker Desktop公式ページ](https://www.docker.com/products/docker-desktop/)へアクセス
2. Dockerに接続  


### Mac


*****
## Dockerコマンド
### コンテナ起動  
    $ docker-compose up -d  
- Dockerファイル系が更新されたとき  
`$ docker-compose up -d --build`

### コンテナの中に入る
    $ docker container exec -it musicle_server /bin/sh
### コンテナから抜ける(コンテナ内のターミナル)
    $ exit