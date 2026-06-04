<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linhas de Linguagem de Validação
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de linguagem contêm as mensagens de erro padrão usadas
    | pela classe validadora. Algumas destas regras têm múltiplas versões,
    | tais como as regras de tamanho. Sente-te livre para alterar estas mensagens.
    |
    */

    'accepted' => 'O campo :attribute deve ser aceite.',
    'accepted_if' => 'O campo :attribute deve ser aceite quando o campo :other é :value.',
    'active_url' => 'O campo :attribute deve ser um URL válido.',
    'after' => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash' => 'O campo :attribute deve conter apenas letras, números, hífenes e sublinhados.',
    'alpha_num' => 'O campo :attribute deve conter apenas letras e números.',
    'any_of' => 'O campo :attribute é inválido.',
    'array' => 'O campo :attribute deve ser uma matriz (array).',
    'ascii' => 'O campo :attribute deve conter apenas caracteres alfanuméricos e símbolos de byte único.',
    'before' => 'O campo :attribute deve ser uma data anterior a :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'array' => 'O campo :attribute deve ter entre :min e :max itens.',
        'file' => 'O ficheiro :attribute deve ter entre :min e :max kilobytes.',
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'string' => 'O campo :attribute deve ter entre :min e :max caracteres.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'can' => 'O campo :attribute contém um valor não autorizado.',
    'confirmed' => 'A confirmação do campo :attribute não coincide.',
    'contains' => 'O campo :attribute não contém um valor obrigatório.',
    'current_password' => 'A password está incorreta.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'date_equals' => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format' => 'O campo :attribute deve corresponder ao formato :format.',
    'decimal' => 'O campo :attribute deve ter :decimal casas decimais.',
    'declined' => 'O campo :attribute deve ser recusado.',
    'declined_if' => 'O campo :attribute deve ser recusado quando o campo :other é :value.',
    'different' => 'Os campos :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'doesnt_contain' => 'O campo :attribute não pode conter nenhum dos seguintes valores: :values.',
    'doesnt_end_with' => 'O campo :attribute não pode terminar com nenhum dos seguintes valores: :values.',
    'doesnt_start_with' => 'O campo :attribute não pode começar com nenhum dos seguintes valores: :values.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'encoding' => 'O campo :attribute deve estar codificado em :encoding.',
    'ends_with' => 'O campo :attribute deve terminar com um dos seguintes valores: :values.',
    'enum' => 'O valor selecionado para o campo :attribute é inválido.',
    'exists' => 'O valor selecionado para o campo :attribute é inválido.',
    'extensions' => 'O campo :attribute deve ter uma das seguintes extensões: :values.',
    'file' => 'O campo :attribute deve ser um ficheiro.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'array' => 'O campo :attribute deve ter mais de :value itens.',
        'file' => 'O ficheiro :attribute deve ser maior do que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior do que :value.',
        'string' => 'O campo :attribute deve ter mais do que :value caracteres.',
    ],
    'gte' => [
        'array' => 'O campo :attribute deve ter :value itens ou mais.',
        'file' => 'O ficheiro :attribute deve ser maior ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'string' => 'O campo :attribute deve ter :value ou mais caracteres.',
    ],
    'hex_color' => 'O campo :attribute deve ser uma cor hexadecimal válida.',
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O valor selecionado para o campo :attribute é inválido.',
    'in_array' => 'O campo :attribute deve existir em :other.',
    'in_array_keys' => 'O campo :attribute deve conter pelo menos uma das seguintes chaves: :values.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'ip' => 'O campo :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O campo :attribute deve ser um endereço IPv4 válido.',
    'ipv6' => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json' => 'O campo :attribute deve ser uma string JSON válida.',
    'list' => 'O campo :attribute deve ser uma lista.',
    'lowercase' => 'O campo :attribute deve estar em minúsculas.',
    'lt' => [
        'array' => 'O campo :attribute deve ter menos de :value itens.',
        'file' => 'O ficheiro :attribute deve ser menor do que :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor do que :value.',
        'string' => 'O campo :attribute deve ter menos do que :value caracteres.',
    ],
    'lte' => [
        'array' => 'O campo :attribute não deve ter mais de :value itens.',
        'file' => 'O ficheiro :attribute deve ser menor ou igual a :value kilobytes.',
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'string' => 'O campo :attribute deve ter :value ou menos caracteres.',
    ],
    'mac_address' => 'O campo :attribute deve ser um endereço MAC válido.',
    'max' => [
        'array' => 'O campo :attribute não deve ter mais de :max itens.',
        'file' => 'O ficheiro :attribute não deve ser maior do que :max kilobytes.',
        'numeric' => 'O campo :attribute não deve ser maior do que :max.',
        'string' => 'O campo :attribute não deve ser maior do que :max caracteres.',
    ],
    'max_digits' => 'O campo :attribute não deve ter mais de :max dígitos.',
    'mimes' => 'O campo :attribute deve ser um ficheiro do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um ficheiro do tipo: :values.',
    'min' => [
        'array' => 'O campo :attribute deve ter pelo menos :min itens.',
        'file' => 'O ficheiro :attribute deve ter pelo menos :min kilobytes.',
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'min_digits' => 'O campo :attribute deve ter pelo menos :min dígitos.',
    'missing' => 'O campo :attribute deve estar em falta.',
    'missing_if' => 'O campo :attribute deve estar em falta quando o campo :other é :value.',
    'missing_unless' => 'O campo :attribute deve estar em falta, a menos que o campo :other seja :value.',
    'missing_with' => 'O campo :attribute deve estar em falta quando o valor :values está presente.',
    'missing_with_all' => 'O campo :attribute deve estar em falta quando os valores :values estão presentes.',
    'multiple_of' => 'O campo :attribute deve ser um múltiplo de :value.',
    'not_in' => 'O valor selecionado para o campo :attribute é inválido.',
    'not_regex' => 'O formato do campo :attribute é inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'password' => [
        'letters' => 'O campo :attribute deve conter pelo menos uma letra.',
        'mixed' => 'O campo :attribute deve conter pelo menos uma letra maiúscula e uma minúscula.',
        'numbers' => 'O campo :attribute deve conter pelo menos um número.',
        'symbols' => 'O campo :attribute deve conter pelo menos um símbolo.',
        'uncompromised' => 'O valor introduzido para o campo :attribute apareceu num vazamento de dados. Por favor, escolha um :attribute diferente.',
    ],
    'present' => 'O campo :attribute deve estar presente.',
    'present_if' => 'O campo :attribute deve estar presente quando o campo :other é :value.',
    'present_unless' => 'O campo :attribute deve estar presente, a menos que o campo :other seja :value.',
    'present_with' => 'O campo :attribute deve estar presente quando o valor :values está presente.',
    'present_with_all' => 'O campo :attribute deve estar presente quando os valores :values estão presentes.',
    'prohibited' => 'O campo :attribute é proibido.',
    'prohibited_if' => 'O campo :attribute é proibido quando o campo :other é :value.',
    'prohibited_if_accepted' => 'O campo :attribute é proibido quando o campo :other é aceite.',
    'prohibited_if_declined' => 'O campo :attribute é proibido quando o campo :other é recusado.',
    'prohibited_unless' => 'O campo :attribute é proibido, a menos que o campo :other esteja em :values.',
    'prohibits' => 'O campo :attribute proíbe o campo :other de estar presente.',
    'regex' => 'O formato do campo :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_array_keys' => 'O campo :attribute deve conter entradas para: :values.',
    'required_if' => 'O campo :attribute é obrigatório quando o campo :other é :value.',
    'required_if_accepted' => 'O campo :attribute é obrigatório quando o campo :other é aceite.',
    'required_if_declined' => 'O campo :attribute é obrigatório quando o campo :other é recusado.',
    'required_unless' => 'O campo :attribute é obrigatório, a menos que o campo :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando o valor :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando os valores :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando o valor :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos valores :values está presente.',
    'same' => 'Os campos :attribute e :other devem coincidir.',
    'size' => [
        'array' => 'O campo :attribute deve conter :size itens.',
        'file' => 'O ficheiro :attribute deve ter :size kilobytes.',
        'numeric' => 'O campo :attribute deve ser :size.',
        'string' => 'O campo :attribute deve ter :size caracteres.',
    ],
    'starts_with' => 'O campo :attribute deve começar com um dos seguintes valores: :values.',
    'string' => 'O campo :attribute deve ser uma string.',
    'timezone' => 'O campo :attribute deve ser uma fuso horário válido.',
    'unique' => 'O valor do campo :attribute já está a ser utilizado.',
    'uploaded' => 'Ocorreu uma falha ao carregar o ficheiro :attribute.',
    'uppercase' => 'O campo :attribute deve estar em maiúsculas.',
    'url' => 'O campo :attribute deve ser um URL válido.',
    'ulid' => 'O campo :attribute deve ser um ULID válido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Linhas de Linguagem de Validação Personalizadas
    |--------------------------------------------------------------------------
    |
    | Aqui podes especificar mensagens de validação personalizadas para atributos
    | usando a convenção "attribute.rule" para nomear as linhas. Isso torna rápido
    | especificar uma linha de linguagem personalizada específica para uma dada regra de atributo.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de Validação Personalizados
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de linguagem são usadas para trocar o nosso marcador
    | de posição do atributo por algo mais amigável para o utilizador, como
    | "Endereço de E-mail" em vez de "email". Isso ajuda-nos a tornar a nossa
    | mensagem mais expressiva.
    |
    */

    'attributes' => [
        'email' => 'endereço de e-mail',
        'password' => 'palavra-passe',
        'password_confirmation' => 'confirmação da palavra-passe',
        'name' => 'nome',
    ],

];
