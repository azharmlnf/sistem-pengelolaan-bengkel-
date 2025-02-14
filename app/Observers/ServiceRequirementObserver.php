<?php

namespace App\Observers;

use App\Models\ServiceRequirement;
use App\Models\SparePart;

class ServiceRequirementObserver
{
    /**
     * Handle the "creating" event.
     * Dikurangi saat data dibuat
     */
    public function creating(ServiceRequirement $serviceRequirement)
    {
        $sparePart = SparePart::find($serviceRequirement->spare_part_id);
        
        if ($sparePart && $sparePart->stock >= $serviceRequirement->quantity) {
            $sparePart->decrement('stock', $serviceRequirement->quantity);
        } else {
            throw new \Exception('Not enough stock available.');
        }
    }

    /**
     * Handle the "updating" event.
     * Sesuaikan stok saat quantity diubah
     */
    public function updating(ServiceRequirement $serviceRequirement)
    {
        $sparePart = SparePart::find($serviceRequirement->spare_part_id);

        if ($sparePart) {
            $quantityDifference = $serviceRequirement->getOriginal('quantity') - $serviceRequirement->quantity;
            $sparePart->increment('stock', $quantityDifference);
        }
    }

    /**
     * Handle the "deleting" event.
     * Kembalikan stok saat data dihapus
     */
    public function deleting(ServiceRequirement $serviceRequirement)
    {
        $sparePart = SparePart::find($serviceRequirement->spare_part_id);

        if ($sparePart) {
            $sparePart->increment('stock', $serviceRequirement->quantity);
        }
    }
}
