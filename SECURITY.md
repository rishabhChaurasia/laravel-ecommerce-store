# Security Policy

## Reporting a Vulnerability

LaraStore takes security seriously. If you discover any security vulnerabilities, please send an email to [rishabh.78275@gmail.com](mailto:rishabh.78275@gmail.com) instead of using the issue tracker.

Please provide a detailed description of the vulnerability, including steps to reproduce, potential impact, and any proof-of-concept code if possible. We will acknowledge your report within 48 hours and will work to address it promptly.

## Security Features Implemented

The LaraStore application includes several security measures:

- **CSRF Protection**: Cross-Site Request Forgery protection on all forms
- **Input Validation and Sanitization**: All user inputs are validated and sanitized
- **SQL Injection Prevention**: Prevention through Eloquent ORM usage
- **XSS Prevention**: Cross-Site Scripting prevention through Blade template escaping
- **Secure Password Hashing**: Passwords are hashed using Laravel's secure hashing methods
- **Authentication Middleware**: Protected routes with Laravel's authentication system
- **Role-Based Access Control**: Proper authorization based on user roles
- **Secure Session Management**: Laravel's secure session handling
- **File Upload Validation**: Validation for file types, sizes, and security checks

## Security Best Practices for Users

If you're using or extending LaraStore, please follow these security best practices:

- Keep dependencies updated and apply security patches promptly
- Use strong, unique passwords for admin accounts
- Regularly backup your database and files
- Enable HTTPS in production environments
- Review and audit custom code for security vulnerabilities
- Limit access to admin panel to authorized personnel only
- Monitor logs for suspicious activity

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Security Updates

Security updates will be released as quickly as possible after a vulnerability is identified and confirmed. We recommend that all users keep their installations up to date with the latest version.