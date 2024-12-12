<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use App\Models\Investigation;
    use App\Models\Collection;
    use App\Models\Business;
    use App\Models\Exploitation;
    use App\Models\Departement;
    use App\Models\Quizze;
    use App\Models\User;
    use App\Models\Region;
    use App\Models\TypeExploitation;
    use App\Models\BusinessCategory;
    use App\Models\BusinessQuizze;
    use App\Models\Indicator;
    use App\Models\SousPrefecture;
    use App\Models\Filiere;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    

    class ApiController extends Controller
    {

        public function __construct()
        {   
            // $this->middleware('authorization');
        }

        public function categories(Request $request)
        {

            $collections = $request->collections;

            if(count($collections)>0){

                foreach($collections as $data){

                    $quizze = Quizze::find($data['investigations'][0]['quizze_id']);

                    $collection = new Collection;
                    $collection->value_chain_id = $quizze->value_chain_id;
                    $collection->category_id = $quizze->category_id; 
                    $collection->user_id = $data['user_id'];
                    $collection->date = $data['date'];
                    $collection->business_id = $data['business_id'];
                    $collection->state = 'pending';
                    $collection->location = json_encode($data['location']);
                    $collection->save();
        
                    foreach($data['investigations'] as $investigation_data){
        
                        $investigation = new Investigation;
                        $investigation->value = $investigation_data['value'];
                        $investigation->indicator_id = $investigation_data['id'];
                        $investigation->collection_id = $collection->id;
                        $investigation->save();
                    }
                }
            }


            $user = User::findOrfail($request->user_id);

            $businesses = [];
            $businesses_data = collect([]);
            $data = [];
            $region = null;
            $departement = null;
            $departement_name = '';
            $sous_prefecture_name = '';

            if(!is_null($user->sous_prefecture_id)){
                $businesses = Business::where('sous_prefecture_id',$user->sous_prefecture_id)->get();
                $businesses_data = $businesses;
                $sous_prefecture_name = $user->sous_prefecture->name;
            }elseif(!is_null($user->departement_id)){
                $departement_name = $user->departement->name;
                $departement = Departement::find($user->departement_id);
            }elseif(!is_null($user->region_id)){
                $region = Region::find($user->region_id);
            }

            foreach ($businesses as $business) {
                foreach($business->business_category as $business_category){
                    $business->region->departement;
                    $business->departement;
                    $business->sous_prefecture;
                    foreach ($business_category->value_chain as $quizze) {

                        $datas = $business_category->value_chain()->whereIn('id',$business->business_quizze->pluck('id'))->get();

                        foreach ($datas as $quizze) {

                            $quizze->value_chain->name;
                            $quizze->indicators;
                            foreach($quizze->indicators as $indicator){
    
                                $indicator->value="";
                                $array = [];
    
                                foreach (json_decode($indicator->data ?? []) as $key => $value) {
                                    $array[] = [
                                            "value" => $value,
                                            "selected" => false,
                                    ];
                                }
                                $indicator->data = $array;
                            }
                        }

                        $business_category->value_chain = $datas;
                    }
                }
            }

            foreach($departement->sous_prefectures ?? [] as $sous_prefecture){
                $sous_prefecture->businesses = Business::where('sous_prefecture_id',$sous_prefecture->id)->get();
                foreach ($sous_prefecture->businesses as $business) {
                    $business->region->departement;
                    $business->departement;
                    $business->sous_prefecture;
                    foreach($business->business_category as $business_category){

                        $datas = $business_category->value_chain()->whereIn('id',$business->business_quizze->pluck('id'))->get();

                        foreach ($datas as $quizze) {

                            $quizze->value_chain->name;
                            $quizze->indicators;
                            foreach($quizze->indicators as $indicator){
    
                                $indicator->value="";
                                $array = [];
    
                                foreach (json_decode($indicator->data ?? []) as $key => $value) {
                                    $array[] = [
                                            "value" => $value,
                                            "selected" => false,
                                    ];
                                }
                                $indicator->data = $array;
                            }
                        }

                        $business_category->value_chain = $datas;
                    }
                }
                $businesses_data = $businesses_data->merge($sous_prefecture->businesses);
            }

            foreach($region->departements ?? [] as $departement){
                foreach($departement->sous_prefectures ?? [] as $sous_prefecture){
                    $sous_prefecture->businesses = Business::where('sous_prefecture_id',$sous_prefecture->id)->get();
                    foreach ($sous_prefecture->businesses as $business) {
                        $business->region->departement;
                        $business->departement;
                        $business->sous_prefecture;
                        foreach($business->business_category as $business_category){

                            $datas = $business_category->value_chain()->whereIn('id',$business->business_quizze->pluck('id'))->get();

                            foreach ($datas as $quizze) {

                                $quizze->value_chain->name;
                                $quizze->indicators;
                                foreach($quizze->indicators as $indicator){
        
                                    $indicator->value="";
                                    $array = [];
        
                                    foreach (json_decode($indicator->data ?? []) as $key => $value) {
                                        $array[] = [
                                                "value" => $value,
                                                "selected" => false,
                                        ];
                                    }
                                    $indicator->data = $array;
                                }
                            }

                            $business_category->value_chain = $datas;
                        }
                    }
                    $businesses_data = $businesses_data->merge($sous_prefecture->businesses);
                }
            }

            if(is_null($region)){

                $data = Region::all();

                foreach($data as $region){                

                    foreach($region->departements as $departement_region){
                        foreach($departement_region->sous_prefectures ?? [] as $sous_prefecture){
                            $sous_prefecture->businesses = Business::where('sous_prefecture_id',$sous_prefecture->id)->get();
                            foreach ($sous_prefecture->businesses as $business) {
                                $business->region->departement;
                                $business->departement;
                                $business->sous_prefecture;
                                foreach($business->business_category as $business_category){

                                    $datas = $business_category->value_chain()->whereIn('id',$business->business_quizze->pluck('id'))->get();

                                    foreach ($datas as $quizze) {

                                        $quizze->value_chain->name;
                                        $quizze->indicators;
                                        foreach($quizze->indicators as $indicator){
                
                                            $indicator->value="";
                                            $array = [];
                
                                            foreach (json_decode($indicator->data ?? []) as $key => $value) {
                                                $array[] = [
                                                        "value" => $value,
                                                        "selected" => false,
                                                ];
                                            }
                                            $indicator->data = $array;
                                        }
                                    }

                                    $business_category->value_chain = $datas;
                                }
                            }
                            $businesses_data = $businesses_data->merge($sous_prefecture->businesses);
                        }
                    }
                }

            }

            $collections_wait = Collection::with('investigations', 'value_chain', 'category', 'business')
            ->where('user_id', $request->user_id)
            ->where('state', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

            $collectionss_success = Collection::with('investigations', 'value_chain', 'category', 'business')
            ->where('user_id', $request->user_id)
            ->where('state', 'success')
            ->orderBy('created_at', 'desc')
            ->get();

            $collections_faild = Collection::with('investigations', 'value_chain', 'category', 'business')
            ->where('user_id', $request->user_id)
            ->where('state', 'faild')
            ->orderBy('created_at', 'desc')
            ->get();

            foreach ($collections_wait as $collection) {
                $indicators = Quizze::where('category_id', $collection->category_id)
                    ->where('value_chain_id', $collection->value_chain_id)
                    ->first()
                    ->indicators;

                $collection->indicators = $indicators;
            }

            foreach ($collectionss_success as $collection) {
                $indicators = Quizze::where('category_id', $collection->category_id)
                    ->where('value_chain_id', $collection->value_chain_id)
                    ->first()
                    ->indicators;

                $collection->indicators = $indicators;
            }

            foreach ($collections_faild as $collection) {
                $indicators = Quizze::where('category_id', $collection->category_id)
                    ->where('value_chain_id', $collection->value_chain_id)
                    ->first()
                    ->indicators;

                $collection->indicators = $indicators;
            }

            $user->role;

            $regions = Region::with([
                'departements' => function ($query) {
                    $query->orderBy('name');
                },
                'departements.sous_prefectures' => function ($query) {
                    $query->orderBy('name');
                }
            ])->orderBy('name')->get();

            $departements = [];
            $sous_prefectures = [];
            $type_exploitations = TypeExploitation::all();
            $categories = Category::with('value_chain.value_chain')->get();
            $filieres = Filiere::with('categories','categories.value_chain.value_chain')->get();

            return response()->json([
                'user'=>$user,
                'data'=>$data,
                'categories'=>$categories,
                'type_exploitations'=>$type_exploitations,
                'departement'=>$departement,
                'filieres'=>$filieres,
                'regions'=>$regions,
                'sous_prefectures'=>$regions,
                'businesses'=>$businesses,
                'businesses_data'=>$businesses_data,
                'departements'=>$departements,
                'exploitations'=>[],
                'region'=>$region,
                'departement_name'=>$departement_name,
                'sous_prefecture_name'=>$sous_prefecture_name,
                'status'=>"success",
                'collections'=>0,
                'collections_all'=> [],
                'collections_success'=> $collectionss_success,
                'collections_wait'=> $collections_wait,
                'collections_faild'=> $collections_faild,
            ], 200);

        }

        public function update_collection(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'investigations' => 'required',
                'date' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            foreach($request->investigations as $investigation_data){

                $investigation = Investigation::find($investigation_data['id']);
                $investigation->value = $investigation_data['value'];
                $investigation->save();
            }

            return response()->json(['message' => 'Enquête modifié avec succès', 'status' => 'success'], 200);
        }

        public function add_collection(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'business_id' => 'required',
                'user_id' => 'required',
                'investigations' => 'required',
                'date' => 'required',
                'exploitation_id'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $quizze = Quizze::find($request->investigations[0]['quizze_id']);

            $collection = new Collection;
            $collection->value_chain_id = $quizze->value_chain_id;
            $collection->category_id = $quizze->category_id;
            $collection->user_id = $request->user_id;
            $collection->date = $request->date;
            $collection->business_id = $request->business_id;
            $collection->state = 'pending';
            $collection->location = json_encode($request->location);
            $collection->save();

            foreach($request->investigations as $investigation_data){

                $investigation = new Investigation;
                $investigation->indicator_id = $investigation_data['id'];
                $investigation->value = $investigation_data['value'];
                $investigation->collection_id = $collection->id;
                $investigation->save();
            }

            if ($collection->save()) {

                return response()->json(['message' => 'Enquête enregistré avec succès', 'status' => 'success'], 200);

            } else {
                return response()->json(["message"=>"Echec de l'enregistrement veuillez réessayer","status"=>"error"], 401);
            }
        }


        public function add_business(Request $request)
        {
            
            $validator = $request->validate([
                'region_id' => 'required|string',
                'departement_id' => 'required|string',
                'phone' => 'required|string',
            ]);
            
            $data = $request->except(['logo']);
            
            
            // $business = Business::where('phone', $data['phone'])->first();

            
            // if ($business) {
            //     return response()->json(['message' => 'Téléphone est déjà utilisée.',"status"=>"error"]);
            // } else {
                $business = Business::updateOrCreate(
                    ['id' => $request->id],
                    $data
                );

                // $business->type_filieres()->sync($request->filiere_ids);

                $business->filieres()->sync($request->filiere_id);
                // $business->type_filieres()->sync($request->filiere_ids);
                $business->categories()->sync($request->category_id);
                $business->quizzes()->sync($request->quizze_id);
            // }

            return response()->json(['message' => 'Fournisseur enregistré avec succès',"status"=>"success"]);

        }


        public function add_exploitation(Request $request)
        {
            
            $validator = $request->validate([
                'region_id' => 'required|string',
                'departement_id' => 'required|string',
                'phone' => 'required|string',
                'location' => 'required|string',
                'user_id' => 'required|string',
            ]);
            
            $data = $request->except(['logo']);
            
            $data['date_of_birth'] = date('Y/m/d',strtotime($data['date_of_birth']));
            
  
            $exploitation = Exploitation::create(
                $data
            );

            // $exploitation->type_filieres()->sync($request->filiere_ids);

            $business_category = new BusinessCategory;
            $business_category->exploitation_id = $exploitation->id;
            $business_category->business_id = $request->business_id;
            $business_category->category_id = $request->category_id;
            $business_category->save();

            foreach($request->quizze_id as $quizze_id){
                    
                $business_quizze = new BusinessQuizze;
                $business_quizze->exploitation_id = $exploitation->id;
                $business_quizze->business_id = $request->business_id;
                $business_quizze->quizze_id = $quizze_id;
                $business_quizze->save();
            }

            return response()->json(['message' => 'Exploitation enregistré avec succès',"status"=>"success"]);

        }

    }