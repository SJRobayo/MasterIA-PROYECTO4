<?php

namespace App\Livewire;

use Livewire\Component;

class CartPage extends Component
{

    public function mount(){
        
    }
    public function render()
    {
        return view('livewire.cart-page')->layout('layouts.app');
    }
}
