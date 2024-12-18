<div class="deznav">
    <div class="deznav-scroll">
      <ul class="metismenu" id="menu">
        
        <li>
            <h4 style="font-weight: bold" class="mb-2"> AGENT </h4>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <i class="flaticon-381-networking"></i>
              <span class="nav-text"> Tableau de bord </span>
            </a>
          <ul aria-expanded="false">
            <li><a href="{{route("dashboard")}}" > Général </a></li>
            <li><a href="#" > Par agence </a></li>
          </ul>
        </li>

    


        @if(Auth::user()->permission("LISTE CLIENT") || Auth::user()->permission("AJOUT CLIENT"))
          <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <i class="flaticon-381-user"></i>
              <span class="nav-text"> Clients </span> 
            </a>

            <ul aria-expanded="false">
              @if(Auth::user()->permission("AJOUT CLIENT"))
                <li>
                  <a href="{{route("customer.add",['ajouter'])}}"> Ajouter un client </a>
                </li>
              @endif

              @if(Auth::user()->permission("LISTE CLIENT")) 
                <li>
                  <a href="{{route("customer.index")}}"> Liste des clients </a>
                </li>
              @endif
            </ul>
          </li>
        @endif

        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
          <i class="flaticon-381-diploma"></i>
          <span class="nav-text"> Contrat </span>
        </a>
        <ul aria-expanded="false">
          <li><a href="#"> Créer un contrat </a></li>
          <li><a href="#"> Liste des contrats </a></li>
        </ul>
        </li>

        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
          <i class="flaticon-381-bookmark-1"></i>
          <span class="nav-text"> Comptabilité </span>
        </a>
        <ul aria-expanded="false">
          <li><a href="#"> Factures </a></li>
          <li><a href="#"> Dépenses </a></li>
        </ul>
        </li>

        @if(Auth::user()->permission("LISTE EMPLOYE") || Auth::user()->permission("AJOUT EMPLOYE"))
          <li class="mb-4">
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <i class="flaticon-381-user-1"></i>
              <span class="nav-text"> Employes </span>
            </a>

            <ul aria-expanded="false">
              @if(Auth::user()->permission("AJOUT EMPLOYE"))
                <li>
                  <a href="{{route("employe.add",['ajouter'])}}"> Ajouter </a>
                </li> 
              @endif

              @if(Auth::user()->permission("LISTE EMPLOYE"))
                <li>
                  <a href="{{route("employe.index")}}"> Liste complète</a>
                </li>
              @endif

              @if(Auth::user()->permission("AJOUT CONTRAT EMPLOYE"))
                <li>
                  <a href="{{route("contrat-employe.add",['ajouter'])}}">  Créer un contrat </a>
                </li>
              @endif

              @if(Auth::user()->permission("LISTE CONTRAT EMPLOYE"))
                <li>
                  <a href="{{route("contrat-employe.index")}}"> Liste des contrats </a>
                </li>
              @endif
            </ul>
          </li>
        @endif



        @if(Auth::user()->permission("LISTE PRODUIT") || Auth::user()->permission("AJOUT PRODUIT"))
          <li class="mt-2">
            <h4 style="font-weight: bold"> ADMINISTRATEUR </h4>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <i class="flaticon-381-box-2"></i>
              <span class="nav-text"> Produits </span>
            </a>

            <ul aria-expanded="false">
              @if(Auth::user()->permission("AJOUT PRODUIT"))
                <li>
                  <a href="{{route("product.add",['ajouter'])}}"> Ajouter un produit</a>
                </li> 
              @endif

              @if(Auth::user()->permission("LISTE PRODUIT"))
                <li>
                  <a href="{{route("product.index")}}"> Liste des produits</a>
                </li>
              @endif
            </ul>
          </li>
        @endif

        @if(Auth::user()->permission("LISTE AGENCE") || Auth::user()->permission("AJOUT AGENCE"))
          <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <i class="flaticon-381-home"></i>
              <span class="nav-text"> Agence </span>
            </a>

            <ul aria-expanded="false">
              @if(Auth::user()->permission("AJOUT AGENCE"))
                <li>
                  <a href="{{route("agence.add",['ajouter'])}}" > Ajouter une agence </a>
                </li>
              @endif

              @if(Auth::user()->permission("LISTE AGENCE"))
                <li>
                  <a href="{{route("agence.index")}}" > Liste des agences </a>
                </li>
              @endif
            </ul>
          </li>
        @endif

        @if(Auth::user()->permission("LISTE AGENT") || Auth::user()->permission("AJOUT AGENT"))
          <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
            <i class="flaticon-381-user"></i>
            <span class="nav-text"> Agent </span>
          </a>

          <ul aria-expanded="false">
            @if(Auth::user()->permission("AJOUT AGENT"))
              <li>
                <a href="{{route("agent.add",['affecter'])}}"> Affecter un agent</a>
              </li>
            @endif

            @if(Auth::user()->permission("LISTE AGENT"))
              <li>
                <a href="{{route("agent.index")}}"> Liste des agents </a>
              </li>
            @endif

          </ul>
          </li>
        @endif

        @if(Auth::user()->permission('AJOUT UTILISATEUR') || Auth::user()->permission('LISTE UTILISATEUR') || Auth::user()->permission('LISTE ROLE') || Auth::user()->permission('LISTE PERMISSION'))
          <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
            <i class="flaticon-381-settings-2"></i>
            <span class="nav-text"> Utilisateur </span>
          </a>

          <ul aria-expanded="false">
            @if(Auth::user()->permission('AJOUT UTILISATEUR'))
              <li>
                <a href="{{route("user.add",['ajouter'])}}"> Ajouter </a>
              </li>
            @endif

            @if(Auth::user()->permission('LISTE UTILISATEUR'))
              <li>
                <a href="{{route("user.index")}}"> Liste </a>
              </li>
            @endif

            @if(Auth::user()->permission('LISTE ROLE'))
              <li>
                <a href="{{route("role.index")}}"> Rôle </a>
              </li>
            @endif

            @if(Auth::user()->permission('LISTE PERMISSION'))
              <li>
                <a href="{{route("permission.index")}}"> Permission </a>
              </li>
            @endif
          </ul>
        </li>
        @endif

      </ul>
      <div class="copyright">
        <p><strong> Babo Corporate </strong> © <script>document.write(new Date().getFullYear())</script> Tous droits réservés </p>
      </div>
    </div>
</div>
