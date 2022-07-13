# musicle

## 環境構築(Docker)
### Windows
1. WSL2の有効化  
    1. Linux用Windowsサブシステムを有効にする  
    PowerShell(管理者モード)  
    ` dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart `
    2. WSL2の実行に関する要件を確認する  
    > https://docs.microsoft.com/ja-jp/windows/wsl/install-manual#step-2---check-requirements-for-running-wsl-2
    3. 
2. Dockerに接続  
    - VSCodeの場合
    1. コマンドパレットを起動して、 `Docker Containers: Attach Shell` を選択
    2. コンテナを選択
    3. ログイン
    `$ su - xxxxx`
    - Terminalの場合
    1. ターミナルを起動(Ubuntu)  
    2. コンテナに入る  
    3. コンテナの停止  

### Dockerコマンド
- Dockerfileからimageをbuildする <br>
`$ docker build -t <ビルドしたイメージの名前> <Dockerfileがあるディレクトリのパス>` <br>
e.g.) `$ docker build -t musicle_server_image ./`
- コンテナの作成、起動
    - 複数コンテナの場合 <br>
    `$ docker-compose up -d`
    - 単数コンテナの場合 <br>
    `$ docker run --name <コンテナの名前> -it <イメージの名前> /bin/bash` <br>
    e.g.) `$docker run --name musicle_server -it musicle_server_image /bin/bash`
- コンテナの起動 <br>
`$ docker start <CONTAINER ID>`
`$ docker exec -it <CONTAINER ID>/<NAME> bash` <br>
- コンテナから抜ける(起動したまま) <br>
`Ctrl + P, Q` <br>
- コンテナの停止 <br>
`$ docker stop <CONTAIER ID>/<NAME>` <br>
- コンテナ再読み込み <br>
`$ docker container restart <CONTAINER ID>/<NAME>` <br>
- <br>
`$ docker ps -a`
- イメージ一覧 <br>
`$ docker image ls`
- コンテナ削除
`$ docker rm <CONTAINER ID>/<NAME>`
- イメージ削除
`$ docker rmi <IMAGE ID>/<NAME>`