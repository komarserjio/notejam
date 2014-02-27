Notejam::Application.routes.draw do
  # You can have the root of your site routed with "root"
  root 'note#list'

  get "pads/:id/edit" => "pad#edit", as: :edit_pad
  post "pads/:id/edit" => "pad#edit"
  
  get "pad/:id/delete" => "pad#delete", as: :delete_pad
  post "pad/:id/delete" => "pad#delete"

  get "pads/create" => "pad#create", as: :create_pad
  post "pads/create" => "pad#create"

  get "notes/create" => "note#create", as: :create_note
  post "notes/create" => "note#create"

  get "notes/:id/edit" => "note#edit", as: :edit_note
  post "notes/:id/edit"

  get "notes/:id/delete" => "note#delete", as: :delete
  post "notes/:id/delete"

  get "note/edit"
  get "note/delete"
  get "note/create"
  get "note/view"
  get "user/signup"
  # The priority is based upon order of creation: first created -> highest priority.
  # See how all your routes lay out with "rake routes".


  # Example of regular route:
  #   get 'products/:id' => 'catalog#view'

  # Example of named route that can be invoked with purchase_url(id: product.id)
  #   get 'products/:id/purchase' => 'catalog#purchase', as: :purchase

  # Example resource route (maps HTTP verbs to controller actions automatically):
  #   resources :products

  # Example resource route with options:
  #   resources :products do
  #     member do
  #       get 'short'
  #       post 'toggle'
  #     end
  #
  #     collection do
  #       get 'sold'
  #     end
  #   end

  # Example resource route with sub-resources:
  #   resources :products do
  #     resources :comments, :sales
  #     resource :seller
  #   end

  # Example resource route with more complex sub-resources:
  #   resources :products do
  #     resources :comments
  #     resources :sales do
  #       get 'recent', on: :collection
  #     end
  #   end

  # Example resource route with concerns:
  #   concern :toggleable do
  #     post 'toggle'
  #   end
  #   resources :posts, concerns: :toggleable
  #   resources :photos, concerns: :toggleable

  # Example resource route within a namespace:
  #   namespace :admin do
  #     # Directs /admin/products/* to Admin::ProductsController
  #     # (app/controllers/admin/products_controller.rb)
  #     resources :products
  #   end
end
