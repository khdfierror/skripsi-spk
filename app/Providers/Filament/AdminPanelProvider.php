<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Login;
use App\Filament\Pages\Profile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\MinimalTheme;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\View\View;
use RalphJSmit\Filament\Pulse\FilamentPulse;

class AdminPanelProvider extends PanelProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Modal::closedByClickingAway(false);
        Table::configureUsing(function (Table $table): void {
            $table->defaultPaginationPageOption(25)
                ->paginationPageOptions([10, 25, 50, 100])
                ->emptyStateHeading('Tidak ada Data');
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->url(fn () => Profile::getUrl()),
            ])
            ->navigationGroups([
                NavigationGroup::make('Data'),
                NavigationGroup::make('Kriteria & Sub Kriteria'),
                NavigationGroup::make('Penilaian'),
                NavigationGroup::make('Matriks')
                    ->icon('carbon-model-builder'),
                NavigationGroup::make('Pengaturan'),
            ])
            ->path('/')
            ->login(Login::class)
            ->colors([
                ...MinimalTheme::getColors(),
                'primary' => Color::Blue,
            ])
            ->icons(MinimalTheme::getIcons())
            ->spa()
            ->font('DM Sans')
            ->maxContentWidth('full')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook('panels::styles.before', fn (): string => Blade::render(<<<'HTML'
                <style>
                    /** Setting Base Font */
                    html, body{
                        font-size: 14px;

                    }

                    .leaflet-container {
                        -webkit-tap-highlight-color: transparent;
                        height: 80vh;

                    }
                    .small {
                        font-size: 12px;
                    }

                    .secondary {
                        color: #6f6f6f;
                    }

                    .fermentasi-pakan {
                        border: 1px solid #edeef1;
                        padding: 2px 5px;
                        border-radius: 5px;
                    }

                    .fi-ta-table .fi-ta-cell .px-3, .fi-ta-table .fi-ta-header-cell.px-3{
                        padding-left: 0.5rem;
                        padding-right: 0.5rem;
                    }
                    .fi-ta-table .fi-ta-cell .py-4{
                        padding-top: 0.4rem;
                        padding-bottom: 0.5rem;
                    }

                    .fi-ta-table .fi-ta-header-cell.py-3\.5{
                        padding-top: 0.5rem;
                        padding-bottom: 0.5rem;
                    }

                    .fi-sidebar-header{
                        @apply border-b-0 border-r !bg-gray-50 dark:!bg-gray-950;
                    }

                    .fi-sidebar-nav{
                        @apply pt-1.5;
                    }

                    /**
                        fix glitch select on spa mode
                    */
                    .fi-fo-select select:not(.fi-select-input){
                        @apply opacity-0 max-h-[30px];
                    }
                </style>
            HTML))
            ->renderHook(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE, fn (): View => view('components.total-records'))
            ->renderHook(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER, fn (): string => Blade::render(<<<'HTML'
                <x-modal-loading wire:loading wire:target="__dispatch,activeTab,gotoPage,nextPage,previousPage,sortTable,tableRecordsPerPage,removeTableFilter,tableGrouping,tableGroupingDirection,toggledTableColumns,tableSearch,tableFilters,resetTableSearch,mountTableAction" />
            HTML))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->plugins([
                (new class extends \BezhanSalleh\FilamentShield\FilamentShieldPlugin
                {
                    public function register(Panel $panel): void
                    { /** dont register resource, just use custom role resource */
                    }
                })::make(),

                FilamentPulse::make()
                    ->navigationGroup('Pengaturan')
                    ->navigationSort(999)
                    ->navigationLabel('Pulse')
                    ->navigationIcon('carbon-activity')
                    ->pageTitle('Pulse')
                    ->slug('pengaturan/pulse'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
