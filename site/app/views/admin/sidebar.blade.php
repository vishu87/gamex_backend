    <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="sidebar-toggler-wrapper">
            <div class="sidebar-toggler">
          </div>
        </li>
        <li style="height:10px">

        </li>
        @if(Auth::User()->priv==1)
          <li <?php if($page_id == 9): ?> class="active" <?php endif; ?> >
            <a href="{{url('admin/addDis')}}">
               <i class="fa fa-cubes"></i>
               <span class="title">Distributors</span>
            </a>
          </li>
        @endif
        @if(Auth::User()->priv==1)
          <li <?php if($page_id == 1): ?> class="active" <?php endif; ?> >
            <a href="{{url('admin')}}">
               <i class="fa fa-cubes"></i>
               <span class="title">Agents</span>
            </a>
          </li>
        @endif
        
           <li <?php if($page_id == 2): ?> class="active" <?php endif; ?> >
              <a href="{{url('agents')}}">
                <i class="fa fa-cubes"></i>
                <span class="title">Users</span>
              </a>
          </li>
        
        <li <?php if($page_id == 3): ?> class="active" <?php endif; ?> >
          <a href="{{url('fundtransfer')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Fund Transfer</span>
          </a>
        </li>
        @if(Auth::User()->priv==-1)
        <li <?php if($page_id == 6): ?> class="active" <?php endif; ?> >
          <a href="{{url('admin/transferhistory')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Transfer History Admin</span>
          </a>
        </li>  
        @endif

        @if(Auth::User()->priv == 1)
        <li <?php if($page_id == 10): ?> class="active" <?php endif; ?> >
          <a href="{{url('admin/alltransferhistory')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">All Transfer History</span>
          </a>
        </li>  
        @endif

        @if(Auth::user()->priv == -2)
        <li <?php if($page_id == 4): ?> class="active" <?php endif; ?> >
          <a href="{{url('agents/transferhistoryagent')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Transfer History</span>
          </a>
        </li>  
        @endif

        @if(Auth::user()->priv == -3)
        <li <?php if($page_id == 10): ?> class="active" <?php endif; ?> >
          <a href="{{url('agents/transferhistorydis')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Transfer History</span>
          </a>
        </li>  
        @endif

        @if(Auth::User()->priv == 1)
          <li <?php if($page_id == 8): ?> class="active" <?php endif; ?> >
            <a href="{{url('admin/stats')}}">
               <i class="fa fa-cubes"></i>
               <span class="title">Stats</span>
            </a>
          </li>
        @endif


        @if(Auth::User()->priv==1)
          <li <?php if($page_id == 11): ?> class="active" <?php endif; ?> >
            <a href="{{url('admin/latest')}}">
               <i class="fa fa-cubes"></i>
               <span class="title">Latest</span>
            </a>
          </li>
        @endif

        <li <?php if($page_id == 7): ?> class="active" <?php endif; ?> >
          <a href="{{url('/change-password')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Change Password</span>
          </a>
        </li>  

        <li <?php if($page_id == 5): ?> class="active" <?php endif; ?> >
          <a href="{{url('/logout')}}">
            <i class="fa fa-cubes"></i>
            <span class="title">Logout</span>
          </a>
        </li>    

      </ul>
    </div>