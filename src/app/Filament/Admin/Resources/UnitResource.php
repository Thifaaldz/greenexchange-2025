<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UnitResource\Pages;
use App\Models\Branch;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('branch_id')
                ->label('Cabang')
                ->options(Branch::all()->pluck('name', 'id'))
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Nama Unit')
                ->required(),

            Forms\Components\FileUpload::make('qr_path')
                ->label('QR Code')
                ->disk('public')
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Nama Unit')->searchable(),
                TextColumn::make('branch.name')->label('Cabang')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => $state === 'active' ? 'success' : 'danger'),

                ImageColumn::make('qr_path')
                    ->label('QR Code')
                    ->square()
                    ->height(80)
                    ->width(80)
                    ->disk('public'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('download_qr')
                    ->label('Download QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Unit $record) {
                        $path = $record->qr_path;

                        if (!$path || !Storage::disk('public')->exists(str_replace('storage/', '', $path))) {
                            throw new \Exception('QR Code tidak ditemukan.');
                        }

                        $realPath = Storage::disk('public')->path(str_replace('storage/', '', $path));
                        return response()->download($realPath);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
