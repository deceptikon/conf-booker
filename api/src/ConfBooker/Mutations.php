<?php
namespace ConfBooker;

class GuestStatus {
  public $status;
  public $name;
  public $isMember;

  function getStatus() {
    return $this->status;
  }

  function getName() {
    return $this->name;
  }

  function getIsMember() {
    return $this->isMember;
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
      $s->isMember = $res->getIsMember();
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
