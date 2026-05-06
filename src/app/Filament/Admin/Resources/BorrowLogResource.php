<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BorrowLogResource\Pages;
use App\Filament\Admin\Resources\BorrowLogResource\RelationManagers;
use App\Models\BorrowLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowLogResource extends Resource
{
    protected static ?string $model = BorrowLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('borrower_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('borrower_contact')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('borrowed_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('returned_at'),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('borrower_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('borrower_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('borrowed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('returned_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowLogs::route('/'),
            'create' => Pages\CreateBorrowLog::route('/create'),
            'edit' => Pages\EditBorrowLog::route('/{record}/edit'),
        ];
    }
}
