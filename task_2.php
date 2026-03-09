<?php
class Person {
    private $name;
    private $login;
    private $password;
    private $age;
    private $data = [];
    public function __construct($name, $login, $password, $age) {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->age = $age;
    }
    public function __get($name) {
        return $this->data[$name] ?? null;
    }
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __sleep() {
        return ['name', 'login', 'age'];
    }
    public function __wakeup() {
    }
    public function __toString() {
        return "Имя: {$this->name}, Логин: {$this->login}, Возраст: {$this->age}";
    }
}
class PeopleList implements Iterator {
    private $people = [];
    private $position = 0;
    public function addPerson(Person $person) {
        $this->people[] = $person;
    }
    public function current() {
        return $this->people[$this->position];
    }
    public function key() {
        return $this->position;
    }
    public function next() {
        $this->position++;
    }
    public function rewind() {
        $this->position = 0;
    }
    public function valid() {
        return isset($this->people[$this->position]);
    }
}
$person = new Person("Иван Иванов", "ivan123", "pass123", 25);
$person->email = "ivan@mail.com";
$serialized = serialize($person);
echo "Сериализованный объект:\n" . $serialized . "\n\n";
$modified = str_replace('ivan123', 'ivan124', $serialized);
echo "Измененная строка (замена на строку того же размера):\n" . $modified . "\n\n";
$modified2 = str_replace('ivan123', 'ivan12345', $serialized);
echo "Измененная строка (замена на строку другого размера):\n" . $modified2 . "\n\n";
try {
    $unserializedPerson = unserialize($modified);
    echo "Десериализованный объект (после замены того же размера):\n";
    echo $unserializedPerson . "\n";
    echo "Email (через __get): " . $unserializedPerson->email . "\n\n";
} catch (Exception $e) {
    echo "Ошибка при десериализации: " . $e->getMessage() . "\n";
}
try {
    $unserializedPerson2 = unserialize($modified2);
    echo "Десериализованный объект (после замены другого размера):\n";
    echo $unserializedPerson2 . "\n";
} catch (Exception $e) {
    echo "Ошибка при десериализации: " . $e->getMessage() . "\n\n";
}
$list = new PeopleList();
$list->addPerson(new Person("Петр Петров", "petr123", "qwerty", 30));
$list->addPerson(new Person("Мария Сидорова", "maria456", "123456", 28));
$list->addPerson(new Person("Анна Иванова", "anna789", "password", 35));
echo "Перебор объектов Person через foreach:\n";
foreach ($list as $index => $person) {
    echo "Элемент $index: " . $person . "\n";
}

?>
