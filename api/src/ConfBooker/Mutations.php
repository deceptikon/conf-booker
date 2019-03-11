<?php
namespace ConfBooker;

class GuestStatus {
  public $status;
  public $name;

  function getStatus() {
    return $this->status;
  }

  function getName() {
    return $this->name;
  }
}

class Mutations {

  function newGuest($data) {
    $s = new GuestStatus;

    $pin = intval(substr($data['pin'], 1, strlen($data['pin'])));
    $user = new UserQuery;
    $res = $user->findOneById($pin);

    if ($res) {
      $conf = new ConferencesQuery();
      $c = $conf->findOneById(1);

      $guest = new Participants();
      $guest->setUser($res);
      $guest->setConference($c);
      $guest->save();
      $s->status = "ok";
      $s->name = $res->getFullname();
    } else {
      $s->status = 'not found';
    }
    return $s;
    $res = [
      'status' => 'ok',
    ];
    return $res; 
  }
}
