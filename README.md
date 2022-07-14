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
  

### Mac


### Dockerコマンド
- Dockerfileからimageをbuildする  
`$ docker build -t <ビルドしたイメージの名前> <Dockerfileがあるディレクトリのパス>`  
e.g.) `$ docker build -t musicle_server_image ./`
- コンテナの作成、起動
    - 複数コンテナの場合  
    `$ docker-compose up -d`
    - 単数コンテナの場合  
    `$ docker run --name <コンテナの名前> -it <イメージの名前> /bin/bash`  
    e.g.) `$docker run --name musicle_server -it musicle_server_image /bin/bash`  
    e.g.) `docker run -it --rm --name musicle_server musicle_server_image` (コンテナを停止した時にコンテナを消してくれる)  
- コンテナの起動  
`$ docker start <CONTAINER ID>`  
`$ docker exec -it <CONTAINER ID>/<NAME> bash`
- コンテナから抜ける(起動したまま)  
`Ctrl + P, Q`
- コンテナの停止  
`$ docker stop <CONTAIER ID>/<NAME>`
- コンテナ再読み込み  
`$ docker container restart <CONTAINER ID>/<NAME>`
- コンテナ情報  
`$ docker ps -a`
- イメージ一覧  
`$ docker image ls`
- コンテナ削除  
`$ docker rm <CONTAINER ID>/<NAME>`
- イメージ削除  
`$ docker rmi <IMAGE ID>/<NAME>`

### 参考にしたページ
- [WSL2インストール(Windows)](https://docs.microsoft.com/ja-jp/windows/wsl/install-manual#step-2---check-requirements-for-running-wsl-2)  
- [AmazonLinux2のDocker系作成](https://dev.classmethod.jp/articles/amazon-linux-2-docker-aws-cli-visual-studio-code/)  
- [DockerにNode.js入れる](https://zenn.dev/kinkinbeer135ml/articles/6369ee73dd1508)  
- [AmazonLinux - Node.jsとnpmを入れる](https://docs.microsoft.com/ja-jp/windows/wsl/install-manual#step-2---check-requirements-for-running-wsl-2)  
- [AmazonLinux2にnpm入れる](https://qiita.com/miriwo/items/4ac80bc51bb072ace652)  
- [yum系コマンド](https://gist.github.com/Ryomasao/c59417972ed9bc4c4ec8c91afde00266)  
- [複数CMDを実行する方法](https://sleepless-se.net/2018/05/26/docker%E3%81%A7%E8%A4%87%E6%95%B0cmd%E3%82%92%E5%AE%9F%E8%A1%8C%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/)  
- [Docker - Ubuntuイメージでのapt-get](https://qiita.com/pochy9n/items/69ab8fc071c187a1f5f8)  
- [Ubuntu起動後、仮想化がうまくいってないときのエラーへの解決方法1(Error: 0x80370102)](https://camedphone.com/archives/1316)  
- [Ubuntu起動後、仮想化がうまくいってませんっていうエラーへの解決方法2(Error: 0x80370102)](https://docs.microsoft.com/en-us/windows/wsl/troubleshooting#error-0x80370102-the-virtual-machine-could-not-be-started-because-a-required-feature-is-not-installed)  
- [Dockerコンテナにphpとかnpmをインストール](https://tsyama.hatenablog.com/entry/docker-not-found-npm)  

***  

## Windows - Docker間ファイル共有
### Windows→Docker
1. エクスプローラー起動
2. パス欄に「\\wsl$」を入力
3. Dockerを選択
### Linux→Windows
1. /mnt/c/xxx... or /mnt/d/xxx... (Windows側の見たいファイルのディレクトリまでのパスを記述)
2. 