# Contributing to LaraStore

Thank you for your interest in contributing to LaraStore! We appreciate your time and effort to help make this project better.

## How to Contribute

### Reporting Issues

- Check existing issues to avoid duplicates
- Use a clear and descriptive title
- Describe the issue in detail
- Include steps to reproduce the problem
- Specify your environment (OS, PHP version, Laravel version, etc.)

### Submitting Pull Requests

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Ensure all tests pass (`php artisan test`)
5. Commit your changes (`git commit -m 'Add amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Development Workflow

- Use PSR-12 coding standards
- Write tests for new features
- Document public methods and classes
- Follow the existing code style
- Keep commits atomic and well described

## Setting up Your Environment

1. Clone your fork of the repository:
   ```bash
   git clone https://github.com/yourusername/larastore.git
   cd larastore
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Environment Configuration:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Database Setup:
   - Configure your database in `.env`
   - Run migrations:
     ```bash
     php artisan migrate
     ```

6. Storage Link:
   ```bash
   php artisan storage:link
   ```

7. Build Assets:
   ```bash
   npm run build
   ```

8. Serve the Application:
   ```bash
   php artisan serve
   ```

## Code Standards

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Write clear, concise comments
- Ensure code is well-structured and maintainable

## Testing

- Write tests for new features or changes
- Run the test suite before submitting a pull request:
  ```bash
  php artisan test
  ```

## Questions?

If you have questions about contributing to the project, feel free to open an issue for discussion.

Thank you again for your interest in contributing!