# Вывод списка заказов с возможностью фильтрации данных

## Требования
- Docker
- Docker Compose
- Make

## Использование

### 1. Запуск Docker контейнеров

Для запуска Docker контейнеров (PHP, MySQL, Nginx):

```bash
make start
```
### 2. Установка зависимостей
Для установки зависимостей проекта с использованием Composer:

```bash
make install
```

### 3. Остановка Docker контейнеров
Для остановки Docker контейнеров:

```bash
make stop
```

### 4. Удаление Docker контейнеров, сетей и томов
Для полной остановки и удаления Docker контейнеров, сетей и томов:

```bash
make down
```

### 5. Просмотр логов Docker контейнеров
Для просмотра логов Docker контейнеров:

```bash
make logs
```

## Дополнительные команды

### Обновление зависимостей
Для обновления зависимостей проекта:
```bash
make update
```

### Помощь
Для посмотра списка всех доступных команд:
```bash
make help
```

## Развертывание

```bash
make start && make install
```