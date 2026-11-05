<?php

test('halaman awal mengarahkan tamu ke login', function () {
    $this->get('/')->assertRedirect('/login');
});
