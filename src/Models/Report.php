<?php
namespace App\Models;

class Report {
	function __construct(
		int $id_shift_type,
		string $name,
		string $route,
		int $book,
		int $brochure,
		int $bible,
		int $magazine,
		int $tract,
		int $address,
		int $talk,
		string $user_note,
		\DateTime $shift_from) {

		$this->id_shift_type = $id_shift_type;
		$this->name = $name;
		$this->route = $route;
		$this->shift_from = $shift_from;
		$this->book = $book;
		$this->brochure = $brochure;
		$this->bible = $bible;
		$this->magazine = $magazine;
		$this->tract = $tract;
		$this->address = $address;
		$this->talk = $talk;
		$this->user_note = $user_note;
	}

	function get_id_shift_type(): int {
		return $this->id_shift_type;
	}

	function get_name(): string {
		return $this->name;
	}

	function get_route(): string {
		return $this->route;
	}

	function get_shift_from(): \DateTime {
		return $this->shift_from;
	}
	function get_book(): int {
		return $this->book;
	}
	function get_brochure(): int {
		return $this->brochure;
	}
	function get_bible(): int {
		return $this->bible;
	}
	function get_magazine(): int {
		return $this->magazine;
	}
	function get_tract(): int {
		return $this->tract;
	}
	function get_address(): int {
		return $this->address;
	}
	function get_talk(): int {
		return $this->talk;
	}
	function get_user_note(): string {
		return $this->user_note;
	}

	protected $id_shift_type, $name, $route, $shift_from, $book, $brochure, $bible, $magazine, $tract, $address, $talk, $user_note;
}