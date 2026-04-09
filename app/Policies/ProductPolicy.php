<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product)
    {
        // kalau admin → boleh hapus semua
        if ($user->role === 'admin') {
            return true;
        }

        // kalau user biasa → hanya miliknya sendiri
        return $user->id === $product->user_id;
    }
}