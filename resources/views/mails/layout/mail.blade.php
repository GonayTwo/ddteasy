<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    @vite('resources/css/mail.css')
</head>

<body>
    <div class="screen-mail h-full px-8 py-12">
        <div class="text-center" style="display: flex; justify-content: center">
            <x-logo />
        </div>
        <h1 class="text-orange-ddteasy text-3xl lg:text-5xl py-8 md:text-left font-bold ">
            Olá, Nome </h1>
        <p class="text-slate-500 py-2">Não compartilhe este link para ninguém, este link dará acesso na sua conta <strong
                class="strong-ddteasy">DDT</strong>easy.</p>
        <p class="text-slate-500 py-2">Se você não solicitou a redefinição de senha, nenhuma ação adicional será
            necessária</p>
        <button href="#" type="submit"
            class="w-full py-2 bg-orange-ddteasy text-white text-2xl font-bold hover:bg-orange-ddteasy/80 ">Resetar
            Senha</button>
    </div>
</body>

</html>
