@extends('layouts.admin-layout')

@push('css')
    <style>
        .user-card {
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@section('page_title', 'Under Armour - Usuários')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Novo Usuário') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @include('admin.users.form')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Função para gerar senha aleatória
        function generateRandomPassword() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*';
            let password = '';
            for (let i = 0; i < 8; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }

        // Event listener para o botão de gerar senha
        document.addEventListener('DOMContentLoaded', function() {
            const generateBtn = document.getElementById('generatePassword');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');

            if (generateBtn) {
                generateBtn.addEventListener('click', function() {
                    const newPassword = generateRandomPassword();
                    passwordField.value = newPassword;
                    confirmPasswordField.value = newPassword;

                    // Mostrar a senha temporariamente
                    const originalType = passwordField.type;
                    passwordField.type = 'text';
                    confirmPasswordField.type = 'text';

                    // Voltar para password após 3 segundos
                    setTimeout(() => {
                        passwordField.type = originalType;
                        confirmPasswordField.type = originalType;
                    }, 3000);

                    // Feedback visual
                    generateBtn.innerHTML =
                        '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Gerada!';
                    generateBtn.classList.add('bg-green-100', 'text-green-800');

                    setTimeout(() => {
                        generateBtn.innerHTML =
                            '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path></svg>Gerar';
                        generateBtn.classList.remove('bg-green-100', 'text-green-800');
                    }, 2000);
                });
            }
        });
    </script>
@endpush
