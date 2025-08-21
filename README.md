# sh-478LcJkbU3HB-9B9

## 使用言語・フレームワーク

- PHP 8.4
  - Laravel 10
- Node.js 22
  - Nuxt 2

## ローカル（開発）環境について

- [画面](http://localhost:3000/)
- [API](http://localhost:8000/)

### 起動手順

```shell
docker compose up -d --build --force-recreate && docker compose logs -f
# もしくは `task up`
```

### 停止手順

```shell
docker compose down -v --remove-orphans
# もしくは `task down`
```
