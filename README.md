# Random Profile Generator for Turkish Data

Generate realistic random Turkish user profiles with detailed information including personal details, addresses, bank accounts, and more.

## Features

- Generates realistic Turkish names and surnames
- Valid TC Kimlik numbers
- Realistic Turkish addresses with coordinates
- Turkish phone numbers with common mobile devices
- Bank account information with Turkish banks
- Job information with Turkish company names and positions
- Marital status with spouse and children information
- Login credentials with secure password hashing
- Network information (IP, MAC addresses)
- Profile images via external services

## Requirements

- PHP 8.3 or higher
- Composer

## Installation

```bash
composer require aksoyih/random-profile
```

## Usage

```php
use Aksoyih\RandomProfile\Factory\RandomProfileFactory;

// Create factory instance
$factory = new RandomProfileFactory();

// Generate a single profile
$profile = $factory->generate();

// Generate multiple profiles
$profiles = $factory->generateMultiple(5);
```

## Example Output

The generated profile includes comprehensive information in the following structure:

```json
{
  "gender": "female",
  "name": "Ayşe",
  "surname": "Yılmaz",
  "tckn": "12345678901",
  "serialNumber": "ABC123XYZ",
  "birthdate": "1990-01-01",
  "age": 33,
  // ... see example.json for full structure
}
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

MIT License