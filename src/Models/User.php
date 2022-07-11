<?php
namespace App\Models;

class User {

    function __construct(
        int $id_user,
        string $username,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        bool $administrative = false,
        bool $active = true,
        string $phone = '',
        string $mobile = '',
        string $congregation = '',
        string $language = '',
        string $note_admin = '',
        string $note_user = ''
    ) {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->administrative = $administrative;
        $this->active = $active;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->congregation = $congregation;
        $this->language = $language;
        $this->note_admin = $note_admin;
        $this->note_user = $note_user;
    }

    function get_id_user(): int {
        return $this->id_user;
    }

    function get_username(): string {
        return $this->username;
    }
    
    function get_firstName(): string {
        return $this->firstName;
    }

    function get_lastName(): string {
        return $this->lastName;
    }

    function get_email(): string {
        return $this->email;
    }

    function get_password(): string {
        return $this->password;
    }

    function active(): bool {
        return $this->active;
    }

    function administrative(): bool {
        return $this->administrative;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function get_congregation(): string {
        return $this->congregation;
    }

    function get_language(): string {
        return $this->language;
    }

    function get_note_user(): string {
        return $this->note_user;
    }

    function get_note_admin(): string {
        return $this->note_admin;
    }

    protected $id_user, $firstName, $lastName, $email, $password, $administrative, $active, $phone, $mobile;
    protected $congregation, $language, $note_user, $note_admin;
}