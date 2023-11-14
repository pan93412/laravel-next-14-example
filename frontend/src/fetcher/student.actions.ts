"use server";

import api from "@/fetcher/endpoint";
import { StudentActions, StudentRequestDto, Students, StudentSchema, StudentsSchema } from "@/fetcher/student.types";
import { revalidateTag } from "next/cache";

export async function getAllStudents(): Promise<Students> {
  "use server";

  const response = await fetch(api("students"), {
    next: {
      tags: ["student"],
    },
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to receive students due to (${response.status}) ${raw}`);
  }

  const json = await response.json();
  return StudentsSchema.parse(json);
}

export async function createStudent(student: StudentRequestDto): Promise<StudentActions> {
  "use server";

  const response = await fetch(api("students"), {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(student),
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to create student due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
  const json = await response.json();
  return StudentSchema.parse(json);
}
