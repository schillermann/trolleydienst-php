# API Documentation

[README](../README.md)

## Emails

### POST `/api/emails/send`

#### Request body

```json
{
  "to": "my@email.org", // required
  "subject": "New Shift", // required
  "text": "You have applied for a new shift.", // optional
  "html": "<!DOCTYPE html><html><body><p>You have applied for a new shift.</p></body></html>" // optional
}
```

#### Responses

| Code | Description          |
| ---- | -------------------- |
| 200  | Successful operation |
| 400  | Invalid input        |
