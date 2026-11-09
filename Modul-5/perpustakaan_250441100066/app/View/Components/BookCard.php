<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookCard extends Component
{
    public $judul;
    public $penulis;
    public $tahunTerbit;
    public $kategori;

    /**
     * Create a new component instance.
     */
    public function __construct($judul = null, $penulis = null, $tahunTerbit = null, $kategori = null)
    {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahunTerbit = $tahunTerbit;
        $this->kategori = $kategori;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.book-card');
    }
}