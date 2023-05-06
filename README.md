# Biblioteca - Backend (Laravel)

**Autor:** Pedro Acácio Rodrigues \
**Email:** pedrorodriguesnh@gmail.com

---

### Introdução 

Repositório destinado ao desenvolvimento de uma API para empréstimos de livros em uma biblioteca.

---

### Necessário 
- PHP
- Composer
- mySQL
  
### Instruções
Realize o clone do repositório
```
cd app/
composer i
```
Certifique que a .env esta preenchida
```
php artisan migrate
php artisan key:generate
php artisan serve
```
### Testes
Para rodar os testes utilize:
```
php artisan test tests/Unit/
```