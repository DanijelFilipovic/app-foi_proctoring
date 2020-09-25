<?php
declare(strict_types=1);

namespace App\Utility;

class Person {
	
	private $firstName;
	private $lastName;
	private $age;
	
	public function __construct(string $firstName, string $lastName, int $age) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->age = $age;
	}

	public function getFirstName(): string {
		return $this->firstName;
	}

	public function getLastName(): string {
		return $this->lastName;
	}

	public function getAge(): int {
		return $this->age;
	}

	public function toArray(): array {
		return [
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'age' => $this->age,
		];
	}
	
	public function toString(): string {
		return "$this->firstName $this->lastName - $this->age";
	}
	
}