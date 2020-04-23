<?php

namespace App\Entity;

use App\Entity\Property;
use Symfony\Component\Validator\Constraints as Assert;

class Contact {
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max= 15)
     */
    private $firstname;

    public function getFirstname(): ?string
    {
		return $this->firstname;
	}

    public function setFirstname(?string $firstname)
    {
		$this->firstname = $firstname;
	}

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max= 15)
     */
    private $lastname;

    public function getLastname(): ?string
    {
		return $this->lastname;
	}

    public function setLastname(?string $lastname)
    {
		$this->lastname = $lastname;
	}

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    public function getEmail(): ?string
    {
		return $this->email;
	}

    public function setEmail($email)
    {
		$this->email = $email;
	}

    /**
     * @Assert\Regex(
     * pattern = "/[0-9]{10}/"
     * )
     */
    private $phone;

	public function getPhone() {
		return $this->phone;
	}

    public function setPhone($phone)
    {
		$this->phone = $phone;
	}

    /**
     * @var string|null
     */
    private $message;

    public function getMessage(): ?string
    {
		return $this->message;
	}

    public function setMessage(?string $message)
    {
		$this->message = $message;
	}

    /**
     * @var Property|null
     */
    private $property;

    public function getProperty()
    {
		return $this->property;
	}

    public function setProperty(Property $property)
    {
		$this->property = $property;
	}

}