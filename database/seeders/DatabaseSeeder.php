<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UsersSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MenuActionsTableSeeder::class);
        $this->call(UserMenuActionsTableSeeder::class);
        $this->call(OtpSmsTableSeeder::class);
        $this->call(CompanyInfosTableSeeder::class);
        $this->call(CustomerInfosTableSeeder::class);
        $this->call(BranchInfosTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SupplierInfosTableSeeder::class);
        $this->call(ProductItemsTableSeeder::class);
        $this->call(ProductBrandsTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductMeasurementsTableSeeder::class);
        $this->call(MeasurementSubunitsTableSeeder::class);
        $this->call(ProductInformationsTableSeeder::class);
        $this->call(CurrentPurchasesTableSeeder::class);
        $this->call(CurrentSalesTableSeeder::class);
        $this->call(CurrentSalesReturnsTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(PasswordResetTokensTableSeeder::class);
        $this->call(PersonalAccessTokensTableSeeder::class);
        $this->call(PurchaseEntriesTableSeeder::class);
        $this->call(PurchaseLedgersTableSeeder::class);
        $this->call(SalesEntriesTableSeeder::class);
        $this->call(SalesLedgersTableSeeder::class);
        $this->call(SalesPaymentsTableSeeder::class);
        $this->call(StocksTableSeeder::class);
        $this->call(SupplierPaymentsTableSeeder::class);
        $this->call(WebsiteInfosTableSeeder::class);
        $this->call(EmployeeInfosTableSeeder::class);
        $this->call(BankInfosTableSeeder::class);
        $this->call(BankTransactionsTableSeeder::class);
        $this->call(EmployeeSalaryPaymentsTableSeeder::class);
        $this->call(EmployeeSalarySetupsTableSeeder::class);
        $this->call(ExpenseEntriesTableSeeder::class);
        $this->call(IncomeEntriesTableSeeder::class);
        $this->call(IncomeExpenseTitlesTableSeeder::class);
        $this->call(InternalLoanProvidesTableSeeder::class);
        $this->call(InternalLoanRecivedsTableSeeder::class);
        $this->call(InternalLoanRegistersTableSeeder::class);
        $this->call(LoanProvidesTableSeeder::class);
        $this->call(LoanRecivedsTableSeeder::class);
        $this->call(LoanRegistersTableSeeder::class);
    }
}