import CustomerLayout from '@/Layouts/CustomerLayout';

export default function Home(){

    return (
        <div>
            Home
        </div>
    )
}

Home.layout = (page:any) => {
return <CustomerLayout children={page}/>
}
