<?php
namespace Models;

class User {

    function __construct(
        int $id_user,
        string $name,
        string $email,
        string $password,
        bool $is_admin = false,
        bool $is_active = true,
        string $phone = '',
        string $mobile = '',
        string $congregation_name = '',
        string $language = '',
        string $note_admin = '',
        string $note_user = ''
    ) {
        $this->id_user = $id_user;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
        $this->is_active = $is_active;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->congregation_name = $congregation_name;
        $this->language = $language;
        $this->note_admin = $note_admin;
        $this->note_user = $note_user;
    }

    function get_id_user(): int {
        return $this->id_user;
    }

    function get_name(): string {
        return $this->name;
    }

    function get_email(): string {
        return $this->email;
    }

    function get_password(): string {
        return $this->password;
    }

    function is_active(): bool {
        return $this->is_active;
    }

    function is_admin(): bool {
        return $this->is_admin;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function get_congregation_name(): string {
        return $this->congregation_name;
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

    protected $id_user, $name, $email, $password, $is_admin, $is_active, $phone, $mobile;
    protected $congregation_name, $language, $note_user, $note_admin;
}