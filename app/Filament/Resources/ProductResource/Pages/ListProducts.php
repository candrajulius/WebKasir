<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Imports\ProductImport;
use Filament\Actions\Action;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import_product')
                ->label('Impor Product')
                ->color('danger')
                ->icon('heroicon-s-arrow-down-tray')
                ->form([
                    FileUpload::make('attachment')
                        ->label('Upload Template Products'),
                ])
                ->action(function (array $data){
                    $file = public_path('storage/'. $data['attachment']);

                    try{
                        Excel::import(new ProductImport, $file);
                        Notification::make()
                            ->title('Product success to import')
                            ->success()
                            ->send();
                    }catch(\Exception $e)
                    {
                        $message = $e->getMessage();
                        Notification::make()
                            ->title('Product failed to import ' . $message)
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('Download Template')
                ->url(route('download-template'))
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
