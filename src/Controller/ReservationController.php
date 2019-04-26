<?php

namespace App\Controller;

use App\Model\ReservationManager;

class ReservationController extends AbstractController
{
    const EMPTY_FIELD = "Veuillez compléter ce champ";

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    /**
     * @param array $cleanPost
     * @return array
     */
    private function checkErrors(array $cleanPost): array
    {
        $errors = [];
        if (empty($cleanPost['name'])) {
            $errors['name'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['email'])) {
            $errors['email'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['phone'])) {
            $errors['phone'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['date'])) {
            $errors['date'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['nbPeople'])) {
            $errors['nbPeople'] = self::EMPTY_FIELD;
        }
        if (empty($cleanPost['appointment'])) {
            $errors['appointment'] = self::EMPTY_FIELD;
        }
        return $errors;
    }

    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $cleanPost = [];
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $cleanPost[$key] = trim($value);
            }
            $errors = $this->checkErrors($cleanPost);
            if (empty($errors)) {
                $reservationManager = new ReservationManager();
                $reservation = [
                    'name' => $cleanPost['name'],
                    'email' => $cleanPost['email'],
                    'phone' => $cleanPost['phone'],
                    'date' => $cleanPost['date'],
                    'nbPeople' => $cleanPost['nbPeople'],
                    'appointment' => $cleanPost['appointment']
                ];
                $reservationManager->insert($reservation);
                header('Location:/Reservation/add');
            }
        }
        return $this->twig->render('/Reservation/add.html.twig', ['errors' => $errors, 'reservation' => $cleanPost]);
    }
}
