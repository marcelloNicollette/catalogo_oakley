<?php

namespace App\View\Components;

use App\Models\ExportUser;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class HistoryModal extends Component
{
    public $exportUsers;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (Auth::check()) {
            $this->exportUsers = ExportUser::where('user_id', Auth::user()->id)
                ->with(['collection', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->exportUsers = collect(); // Coleção vazia se não autenticado
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.history-modal');
    }
}
