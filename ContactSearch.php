<?php

/**
 * PHP ver. 5.6 (interpeter 5.6.23)
 *
 * Handles contact data from CSV in multidimensional array for search and
 * manipulation.
 *
 * User: Sang Cao
 * Date: 7/8/2016
 */
class ContactSearch {
    private $filepath = '';
    private $contacts = [];

    private $format = "Last: %s, First: %s, Phone: %s, E-mail: %s";


    /**
     * Constructor: Given a filepath to CSV, gets contact info from and formats
     * into an associative array with email as the key.
     *
     * @param $filepath
     */
     public function __construct($filepath) {
        $this->filepath = $filepath;

        $data = file($filepath);
        $header = str_getcsv(array_shift($data));

        foreach ($data as $line) {
            $contact = array_combine($header, str_getcsv($line));
            $this->contacts[$contact['email']] = $contact;
        }
    }


    /**
     * Gets contact information by given email.
     *
     * @param $email
     * @return array
     */
    public function getByEmail($email) {
        if (isset($this->contacts[$email])) {
            echo $this->formatContact($email, $this->contacts[$email]);

            return 1;
        } else {
            echo 'Error: Contact does not exist';
            return 0;
        }
    }


    /**
     * Filters contact array by first initial and prints formatted list.
     *
     * @param $letter
     * @return int
     */
    public function getByLastInitial($letter) {
        if (strlen($letter) == 1) {
            $contacts = array_filter($this->contacts, function($a) use ($letter) {
                return (strtolower(substr($a['last_name'], 0, 1)) == $letter);
            });

            // Sort by last name
            uasort($contacts, function($a, $b) {
                return strcmp($a['last_name'], $b['last_name']);
            });

            foreach ($contacts as $key => $contact) {
                echo $this->formatContact($key, $contact) . '<br>';
            }

            return 1;
        } else {
            echo 'Error: Input must be a single letter';
            return 0;
        }
    }

    /**
     * Function to get contact data in array form.
     *
     * @return array
     */
    public function getContacts() {
        return $this->contacts;
    }


    /**
     * Formats a contact array and returns formatted string.
     *
     * @param $array
     * @param $key
     * @return string
     */
    private function formatContact($key, $array) {
        return sprintf($this->format, $array['last_name'], $array['first_name'],
            $array['phone'], $key);
    }
}
