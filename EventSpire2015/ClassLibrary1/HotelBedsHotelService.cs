using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public class HotelBedsHotelService : IHotelService
    {
        public async Task<HotelSearchResponse> Search(HotelSearchRequest hotelSearchRequest)
        {
            var url = "http://api.hotelbeds.com/hotel-api/1.0/availability";
            var json = System.IO.File.ReadAllText(@"C:\code\thack2015\JSONSamples\HotelBedsRequest.json");
            using (var httpClient = new HttpClient())
            {
                httpClient.DefaultRequestHeaders.Accept.Add(new MediaTypeWithQualityHeaderValue("application/json"));

                HttpRequestMessage request = new HttpRequestMessage(HttpMethod.Post, url);
                // Add our custom user agent
                request.Headers.Add("Api-Key", "6262k3bddqe67jsbahb9wqnx");
                // Send the request to the server
                // Send the request to the server
                HttpResponseMessage response = await httpClient.SendAsync(request);
            }

            return new HotelSearchResponse();
        }
    }
}
