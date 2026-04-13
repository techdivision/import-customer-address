# AGENTS.md - import-customer-address

## Zweck & Verantwortung

Das `import-customer-address` Modul bietet **Customer Address Import-Funktionalität**. Es ist ein **Tier 5 Modul** und erweitert `import-customer`.

**Hauptverantwortung:**
- Customer Address Import
- Address Attributes Import
- Repository Pattern für Customer Addresses
- Service Layer für Address-Verarbeitung
- Observer Pattern für Address-Hooks

## Architektur & Design Patterns

### Kern-Klassen
- **CustomerAddressRepository**: Persistierung von Adressen
- **CustomerAddressAttributeRepository**: Persistierung von Address Attributes
- **CustomerAddressProcessor**: Service Layer
- **CustomerAddressObserver**: Observer für Hooks

### Verwendete Patterns
- **Observer Pattern**: Für Address-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Service Layer**: Für Business Logic

## Abhängigkeiten

### Externe Pakete
- **Keine**

### TechDivision Dependencies
- **import-customer** ^18.1 - Customer Importer

### Abhängig von diesem Modul (1 Reverse Dependency)
- **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// Customer Address Repository
CustomerAddressRepository::create($row): void
CustomerAddressRepository::findByCustomerId($customerId): array

// Customer Address Attribute Repository
CustomerAddressAttributeRepository::create($row): void
```

## Events & Extension Points

**Keine Events** - Tier 5 Importer-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 5 Modul**: Erweitert Customer Importer
2. **Spezialisiert**: Nur für Customer Addresses
3. **Observer Pattern**: Für Hooks
4. **Repository Pattern**: Für Persistierung

## Bekannte Einschränkungen

- **Address-Only**: Keine anderen Features
- **Abhängig von Customers**: Erfordert Customers zu existieren

## Zusammenfassung

`import-customer-address` ist ein **Tier 5 Modul**, das Customer Address Import-Funktionalität bietet. Es erweitert den Customer Importer mit spezialisierter Funktionalität.

**Für Agenten:** Verstehe dieses Modul als **Customer Address Importer** mit Observer und Repository Pattern.
